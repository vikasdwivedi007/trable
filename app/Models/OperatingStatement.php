<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class OperatingStatement extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Operating-Statement';

    protected $fillable = ['date', 'job_id', 'emp_id'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date:l d F Y',
    ];

    public $can_search_by = ['date', 'job_file.file_no', 'employee_user.name'];

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public static function viewIndex()
    {
        $query = self::select([
            'operating_statements.*',
            'job_file.file_no as job_file.file_no',
            'employee.user_id as employee.user_id',
            'employee_user.name as employee_user.name'
        ])
            ->leftJoin('job_files as job_file', 'operating_statements.job_id', '=', 'job_file.id')
            ->leftJoin('employees as employee', 'operating_statements.emp_id', '=', 'employee.id')
            ->join('users as employee_user', 'employee.user_id', '=', 'employee_user.id');

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

        $operating_statements = $query->get();
        $operating_statements->map->formatObject();
        return Helpers::FormatForDatatable($operating_statements, $count);
    }

    public function formatObject()
    {
        $this->job_file = (object)['file_no' => $this->{'job_file.file_no'}];
        $this->date = $this->date->format('d-m-Y');
        $this->employee_user = (object)['name' => $this->{'employee_user.name'}];
    }

    public static function getOperatingMonthlyReport(Carbon $date)
    {
        $start = clone $date;
        $end = clone $date;
        $start = $start->startOfMonth();
        $end = $end->endOfMonth();
        $employees = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->whereHas('operating_statements', function ($inner) use ($start, $end) {
            $inner->where('date', '>=', $start)->where('date', '<=', $end);
        })->with([
            'operating_statements' => function($inner) use ($start, $end){
                $inner->where('date', '>=', $start)->where('date', '<=', $end);
            }, 'operating_statements.job_file', 'user'])->get();

        if (!$employees->count()) {
            return [];
        }

        $employees_names = $employees->pluck('user.name', 'id')->toArray();
        $employees_init = [];
        foreach($employees_names as $key => $employees_name){
            $employees_init[] = [
                'id' => $key,
                'name' => $employees_name,
                'file_no' => ''
            ];
        }
        $data = [];
        for($i=$start->day; $i<= $end->day; $i++){
            $day_num = $i;
            if($i<10){
                $day_num = '0'.$i;
            }
            $day = $day_num.'-'.$date->format('m-Y');
            $data[$day] = [];
            foreach($employees_init as $row){
                $data[$day][$row['id']] = $row;
            }
        }
        foreach ($employees as $employee) {
            foreach ($employee->operating_statements as $statement) {
                $data[$statement->date->format('d-m-Y')][$statement->emp_id]['file_no'] = $statement->job_file->file_no;
            }
        }
        foreach($data as $day => $day_data){
            $empty = true;
            foreach($day_data as $emp_id => $emp_data){
                if($emp_data['file_no']){
                    $empty = false;
                }
            }
            if($empty){
                unset($data[$day]);
            }
        }
        return $data;
    }
}
