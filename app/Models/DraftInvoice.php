<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class DraftInvoice extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Draft-Invoice';

    protected $fillable = ['created_by', 'job_id', 'number', 'total', 'currency', 'total_without_vat'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['number', 'job_file.file_no', 'job_file.client_name', 'job_file.adults_count', 'job_file.children_count', 'travel_agent.name'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($draft_invoice) {
            $draft_invoice->created_by = auth()->user()->employee->id;
        });

        //after being created (without number)
        self::created(function ($draft_invoice) {
            $draft_invoice->generateNumber();
        });

        self::deleting(function ($draft_invoice) {
            $draft_invoice->items()->delete();
        });
    }

    public function created_by()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function items()
    {
        return $this->hasMany(DraftInvoiceItem::class, 'draft_invoice_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'draft_invoice_id');
    }

    public function generateNumber()
    {
        $year_start = Carbon::createFromFormat("d-m-Y", $this->job_file->arrival_date->format('d-m-Y'))->startOfYear();
        $year_end = Carbon::createFromFormat("d-m-Y", $this->job_file->arrival_date->format('d-m-Y'))->endOfYear();
        $count = self::whereHas('job_file', function ($inner) use ($year_start, $year_end) {
            $inner->where('arrival_date', '>=', $year_start)->where('arrival_date', '<=', $year_end);
        })->count();
        //don't add 1 to count because this invoice already created, no need to add 1 because count() already included this new invoice
        $number = $count . '/' . $this->job_file->arrival_date->format('Y');
        while (self::where('number', $number)->count()) {
            $count++;
            $number = $count . '/' . $this->arrival_date->format('Y');
        }
        $this->number = $number;
        $this->save();
    }

    public static function draftInvoicesIndex()
    {
        $query = self::select([
            'draft_invoices.*',
            'job_file.file_no as job_file.file_no',
            'job_file.client_name as job_file.client_name',
            'job_file.adults_count as job_file.adults_count',
            'job_file.children_count as job_file.children_count',
            'job_file.arrival_date as job_file.arrival_date',
            'travel_agent.name as travel_agent.name',
        ])->leftJoin('job_files as job_file', 'draft_invoices.job_id', '=', 'job_file.id')
            ->join('travel_agents as travel_agent', 'job_file.travel_agent_id', '=', 'travel_agent.id');

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

        $draft_invoices = $query->with('job_file')->get();
        $draft_invoices->map->formatObjectForDatatable();
        return Helpers::FormatForDatatable($draft_invoices, $count);
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
        $this->{"job_file.request_date"} = $this->job_file->request_date->format('M Y');
        $this->total = $this->total . ' ' . Currency::currencyName($this->currency);
        $this->travel_agent = (object)['name' => $this->{"travel_agent.name"}];
    }

}
