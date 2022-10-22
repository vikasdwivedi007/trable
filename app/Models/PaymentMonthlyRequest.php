<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentMonthlyRequest extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Payment-Monthly-Request';

    protected $fillable = ['date', 'request_date', 'files_count', 'amount', 'total', 'words'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date', 'request_date'];
    protected $casts = [
        'date' => 'date:d-m-Y',
        'request_date' => 'date:l d F Y',
    ];

    public $can_search_by = ['date', 'files_count', 'amount', 'total'];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($payment_request) {
            $payment_request->total = round($payment_request->files_count * $payment_request->amount, 2);
        });
    }

    public static function viewIndex()
    {
        $query = self::select([
            'payment_monthly_requests.*',
            'payment_monthly_requests.date as month',
        ]);

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

        $payment_requests = $query->get();
        $payment_requests->map->formatObject();
        return Helpers::FormatForDatatable($payment_requests, $count);
    }

    public function formatObject()
    {
        $this->month = $this->date->format('Y-m');
        $this->request_date = $this->toArray()['request_date'];
        $this->amount .= ' EGP';
        $this->total .= ' EGP';
    }

}
