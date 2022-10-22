<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class TrafficMonthlyCommission extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Traffic-Monthly-Commission';

    protected $fillable = ['date', 'job_id', 'amount'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date:d-m-Y',
    ];

    public $can_search_by = ['date', 'job_file.file_no', 'amount'];

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public static function viewIndex()
    {
        $query = self::select([
            'traffic_monthly_commissions.*',
            'traffic_monthly_commissions.date as month',
            'job_file.file_no as job_file.file_no',
        ])
            ->leftJoin('job_files as job_file', 'traffic_monthly_commissions.job_id', '=', 'job_file.id');

        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $query->count();
        $sum = $query->sum('amount');
        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $commissions = $query->get();
        $commissions->map->formatObject($sum);
        return Helpers::FormatForDatatable($commissions, $count);
    }

    public function formatObject($sum = 0)
    {
        $this->job_file = (object)['file_no' => $this->{'job_file.file_no'}];
        $this->month = $this->date->format('m-Y');
        $this->amount .= ' EGP';
        $this->sum = floatval($sum);
    }
}
