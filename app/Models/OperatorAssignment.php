<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class OperatorAssignment extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Operator-Assignment';

    protected $fillable = ['date', 'job_id', 'emp_id', 'daily_sheet_id', 'status', 'router_number', 'remarks', 'itinerary'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date:l d F Y'
    ];

    public $can_search_by = ["travel_agent.name", "job_file.file_no", "job_file.client_name", "operator_user.name"];

    const STATUS_NOT_YET = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DENIED = 2;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($assignment) {
            $assignment->status = self::STATUS_NOT_YET;
        });

    }

    /*public function setDailySheetIdAttribute($daily_sheet_id)
    {
        //don't edit daily sheet id
        if ($this->daily_sheet_id)
            return;
    }*/

    public function daily_sheet()
    {
        return $this->belongsTo(DailySheetFile::class, 'daily_sheet_id');
    }

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function operator()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public static function viewIndex()
    {
        $query = self::select([
            'operator_assignments.*',
            'job_file.file_no as job_file.file_no',
            'job_file.client_name as job_file.client_name',
            'travel_agent.name as travel_agent.name',
            'operator.user_id as operator.user_id',
            'operator_user.name as operator_user.name'
        ])->leftJoin('job_files as job_file', 'operator_assignments.job_id', '=', 'job_file.id')
            ->leftJoin('employees as operator', 'operator_assignments.emp_id', '=', 'operator.id')
            ->join('users as operator_user', 'operator.user_id', '=', 'operator_user.id')
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

        $auth_emp = auth()->user()->employee;
        if ($auth_emp->job && $auth_emp->job->title == JobTitle::OPERATOR_TITLE) {
            $query->where('emp_id', $auth_emp->id);
        }

        $assignments = $query->get();
        $assignments->map->formatObjectForDatatable();
        return Helpers::FormatForDatatable($assignments, $count);
    }

    public function formatObjectForDatatable()
    {
        $this->date = $this->date->format('l d F Y');
        switch ($this->status) {
            case self::STATUS_NOT_YET:
                $this->status = 'Not Yet';
                break;
            case self::STATUS_APPROVED:
                $this->status = 'Yes';
                break;
            case self::STATUS_DENIED:
                $this->status = 'No';
                break;
        }
        $this->travel_agent = (object)['name' => $this->{'travel_agent.name'}];
        $this->job_file = (object)['file_no' => $this->{'job_file.file_no'}, 'client_name' => $this->{'job_file.client_name'}];
        $this->operator_user = (object)['name' => $this->{'operator_user.name'}];
        $this->can_reveiew = auth()->user()->can('review', $this);
    }

    public static function prepareData($data)
    {
        $job_file = JobFile::where('file_no', $data['file_no'])->first();
        $data['job_id'] = $job_file->id;
        $sheet = $job_file->getLastDailySheet($data['date']);
        $data['daily_sheet_id'] = $sheet ? $sheet->id : null;
        return $data;
    }

}
