<?php

namespace App\Models;

use App\Helpers;
use App\Jobs\ReminderJob;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Reminder extends Model
{
    use SerializeDate;

    protected $fillable = ['title', 'desc', 'assigned_to_id', 'send_at', 'send_by', 'status', 'assigned_by_id'];

    const PERMISSION_NAME = 'Reminder';

    protected $dates = ['send_at'];

    protected $casts = [
        'send_at' => 'date:l d F Y H:i'
    ];

    public $can_search_by = ['title', 'desc', 'status', 'assigned_by_user.name', 'assigned_to_user.name'];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($reminder) { // before delete() method call this
            $reminder->deleteJob();
        });
    }

    public function setSendAtAttribute($send_at)
    {
        $this->attributes['send_at'] = Carbon::createFromFormat('l d F Y H:i', $send_at);
    }

    public function setSendByAttribute($send_by)
    {
        $this->attributes['send_by'] = json_encode($send_by);
    }

    public function getSendByAttribute($send_by)
    {
        if ($send_by) {
            return json_decode($send_by, true);
        }
        return [];
    }

    public function assigned_to()
    {
        return $this->belongsTo(Employee::class, 'assigned_to_id');
    }

    public function assigned_by()
    {
        return $this->belongsTo(Employee::class, 'assigned_by_id');
    }

    public static function reminderIndex()
    {
        $query = Reminder::select([
            'reminders.*',
            'assigned_by_employee.id as assigned_by_employee.id',
            'assigned_by_employee.user_id as assigned_by_employee.user_id',
            'assigned_to_employee.id as assigned_to_employee.id',
            'assigned_to_employee.user_id as assigned_to_employee.user_id',
            'assigned_by_user.name as assigned_by_user.name',
            'assigned_to_user.name as assigned_to_user.name',
        ])->join('employees as assigned_by_employee', 'reminders.assigned_by_id', '=', 'assigned_by_employee.id')
            ->join('employees as assigned_to_employee', 'reminders.assigned_to_id', '=', 'assigned_to_employee.id')
            ->join('users as assigned_by_user', 'assigned_by_employee.user_id', '=', 'assigned_by_user.id')
            ->join('users as assigned_to_user', 'assigned_to_employee.user_id', '=', 'assigned_to_user.id');

        $query->where(function ($query) {
            $query->where('assigned_to_id', auth()->user()->employee->id)->orWhere('assigned_by_id', auth()->user()->employee->id);
        });

        $reminders = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $reminders->count();
        $reminders = app(Pipeline::class)->send($reminders)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $reminders = $reminders->with(['assigned_to', 'assigned_to.user', 'assigned_by', 'assigned_by.user'])->get();
        $reminders->map->statusToText();
        $reminders->map->sendByToText();
        $reminders->map->checkIfCanDelete();
        $reminders->map->insertCustomFields();
        return Helpers::FormatForDatatable($reminders, $count);
    }

    public function addJob($at = null)
    {
        if ($at) {
            $job = (new ReminderJob($this))->delay($at);
        } else {
            $job = (new ReminderJob($this));
        }
        $id = app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        if ($id) {
            $this->job_id = $id;
            $this->save();
        }
    }

    public function deleteJob()
    {
        if ($this->job_id) {
            DB::table('jobs')->delete($this->job_id);
        }
        //no need to nullify job_id field because it will be replaced anyway with addJob
    }

    public static function prepareData($data)
    {
        $data['assigned_by_id'] = auth()->user()->employee->id;
        return $data;
    }

    public function setJob()
    {
        if ($this->send_at) {
            $this->deleteJob();
            $this->addJob($this->send_at);
        } else {
            $this->addJob();
        }
    }

    public function statusToText()
    {
        switch ($this->status) {
            case 0:
                $this->status = 'ToDo';
                break;
            case 1:
                $this->status = 'Pending';
                break;
            case 2:
                $this->status = 'Done';
                break;
        }
    }

    public function sendByToText()
    {
        $str = '';
        foreach ($this->send_by as $send_by) {
            if ($send_by == 'db') {
                $send_by = 'popup';
            }
            $str .= $send_by . ', ';
        }
        $this->send_by = trim($str, ', ');
    }

    public function checkIfCanDelete()
    {
        $response = Gate::inspect('delete', $this);
        if ($response->allowed()) {
            $this->can_delete = true;
        } else {
            $this->can_delete = false;
        }
    }

    public function insertCustomFields()
    {
        $this->assigned_to_user = (object)['name' => $this->assigned_to->user->name];
        $this->assigned_by_user = (object)['name' => $this->assigned_by->user->name];
    }

    public static function searchForStatus($filter_q)
    {
        return Arr::where(['Todo', 'Pending', 'Done'], function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }
}
