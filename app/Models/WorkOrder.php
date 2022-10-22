<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkOrder extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Work-Order';

    protected $fillable = ['date', 'emp_id', 'job_id'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date:l d F Y'
    ];

    public $can_search_by = ["job_file.file_no", "job_file.arrival_flight", "job_file.arrival_date", "representative_user.name", "representative_user.phone" ];

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function representative()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public static function viewIndex()
    {
        $query = self::select([
            'work_orders.*',
            'job_file.file_no as job_file.file_no',
            'job_file.arrival_flight as job_file.arrival_flight',
            'job_file.arrival_date as job_file.arrival_date',
            'representative.user_id as representative.user_id',
            'representative_user.name as representative_user.name',
            'representative_user.phone as representative_user.phone'
        ])
            ->leftJoin('job_files as job_file', 'work_orders.job_id', '=', 'job_file.id')
            ->leftJoin('employees as representative', 'work_orders.emp_id', '=', 'representative.id')
            ->join('users as representative_user', 'representative.user_id', '=', 'representative_user.id');

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

        $rows = $query->get();
        $rows->map->formatObjectForDatatable();
        return Helpers::FormatForDatatable($rows, $count);
    }

    public function formatObjectForDatatable()
    {
        $this->can_edit = auth()->user()->can('update', $this);
        $this->can_delete = auth()->user()->can('delete', $this);
        $this->can_view = auth()->user()->can('view', $this);
        $this->edit_path = route('work-orders.edit', ['work_order' => $this->id]);
        $this->delete_path = route('work-orders.destroy', ['work_order' => $this->id]);
        $this->view_path = route('work-orders.show', ['work_order' => $this->id]);

        $this->serial_no = sprintf("%03d", $this->id);
        $this->job_file = (object)[
            'file_no' => $this->{"job_file.file_no"},
            'arrival_flight' => $this->{"job_file.arrival_flight"},
            'arrival_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->{"job_file.arrival_date"})->format('l d F Y'),
        ];
        $this->representative_user = (object)[
            'name' => $this->{'representative_user.name'},
            'phone' => $this->{'representative_user.phone'},
        ];

//        $this->date = $this->date->format('l d F Y');
    }

}
