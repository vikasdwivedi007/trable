<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Invoice';

    protected $fillable = ['created_by', 'draft_invoice_id', 'date', 'number', 'total', 'currency', 'total_without_vat', 'status'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date:d F Y'
    ];

    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    public $can_search_by = ['invoices.number', 'job_file.file_no', 'job_file.client_name', 'job_file.command_no', 'travel_agent.name', 'invoices.status'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($invoice) {
            $invoice->created_by = auth()->user()->employee->id;
        });

        //after being created (without number)
        self::created(function ($invoice) {
            $invoice->generateNumber();
        });

        self::deleting(function ($invoice) {
            $invoice->items()->delete();
        });
    }

    public function created_by()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function draft_invoice()
    {
        return $this->belongsTo(DraftInvoice::class, 'draft_invoice_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function generateNumber()
    {
        $year_start = Carbon::createFromFormat("d-m-Y", $this->draft_invoice->job_file->arrival_date->format('d-m-Y'))->startOfYear();
        $year_end = Carbon::createFromFormat("d-m-Y", $this->draft_invoice->job_file->arrival_date->format('d-m-Y'))->endOfYear();
        $count = self::whereHas('draft_invoice.job_file', function ($inner) use ($year_start, $year_end) {
            $inner->where('arrival_date', '>=', $year_start)->where('arrival_date', '<=', $year_end);
        })->count();
        //don't add 1 to count because this invoice already created, no need to add 1 because count() already included this new invoice
        $number = $count . '/' . $this->draft_invoice->job_file->arrival_date->format('Y');
        while (self::where('number', $number)->count()) {
            $count++;
            $number = $count . '/' . $this->arrival_date->format('Y');
        }
        $this->number = $number;
        $this->save();
    }

    public static function invoicesIndex()
    {
        $query = self::select([
            'invoices.*',
            'invoices.id as serial_no',
            'draft_invoice.id as draft_invoice.draft_invoice_id',
            'job_file.file_no as job_file.file_no',
            'job_file.client_name as job_file.client_name',
            'job_file.arrival_date as job_file.arrival_date',
            'job_file.departure_date as job_file.departure_date',
            'job_file.command_no as job_file.command_no',
            'travel_agent.name as travel_agent.name',
        ])
            ->leftJoin('draft_invoices as draft_invoice', 'invoices.draft_invoice_id', '=', 'draft_invoice.id')
            ->leftJoin('job_files as job_file', 'draft_invoice.job_id', '=', 'job_file.id')
            ->leftJoin('travel_agents as travel_agent', 'job_file.travel_agent_id', '=', 'travel_agent.id');

        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $query->count();
        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $invoices = $query->with(['draft_invoice', 'draft_invoice.job_file'])->get();
        $invoices->map->formatObjectForDatatable();
        return Helpers::FormatForDatatable($invoices, $count);
    }

    public function createOrUpdateItems($data)
    {
        $this->items()->delete();
        $total = 0;
        $total_without_vat = 0;
        $currency = 1;
        if (isset($data['items']) && $data['items']) {
            $i = 0;
            foreach ($data['items'] as $item) {
                if ($i == 0) {
                    $currency = $item['currency'];
                }
                $item['price_without_vat'] = floatval($item['price']);
                $item['price'] = round(($item['price_without_vat']) + ($item['price_without_vat'] * floatval($item['vat']) / 100), 2);
                if ($item['price'] >= 0) {
                    $this->items()->create($item);
                    $total += $item['price'];
                    $total_without_vat += $item['price_without_vat'];
                }
                $i++;
            }
        }
        $this->currency = $currency;
        $this->total = round($total, 2);
        $this->total_without_vat = round($total_without_vat, 2);
        $this->save();
    }

    public function formatObjectForDatatable()
    {
        $this->{"job_file.arrival_date"} = $this->draft_invoice->job_file->arrival_date->format('d F Y');
        $this->{"job_file.departure_date"} = $this->draft_invoice->job_file->departure_date->format('d F Y');
        $this->total = $this->total . ' ' . Currency::currencyName($this->currency);
        $this->status = $this->status ? "Paid" : "Unpaid";
        $this->travel_agent = (object)['name' => $this->{"travel_agent.name"}];
        $this->job_file = (object)[
            'file_no' => $this->{"job_file.file_no"},
            'client_name' => $this->{"job_file.client_name"},
            'arrival_date' => $this->{"job_file.arrival_date"},
            'departure_date' => $this->{"job_file.departure_date"},
            'command_no' => $this->{"job_file.command_no"}
        ];
        $this->pax = $this->draft_invoice->job_file->adults_count + $this->draft_invoice->job_file->children_count;
        $this->operator_name = $this->draft_invoice->job_file->operator()->user->name;
        $this->serial_no = sprintf("%04d", $this->id);
    }

    public static function availableStatus()
    {
        return [
            self::STATUS_UNPAID => 'Unpaid',
            self::STATUS_PAID => 'Paid',
        ];
    }

    public static function searchForStatus($filter_q)
    {
        return Arr::where(self::availableStatus(), function ($value, $key) use ($filter_q) {
            if (strtolower($value) == strtolower($filter_q)) {
                return true;
            }
        });
    }
}
