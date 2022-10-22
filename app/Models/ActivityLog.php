<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use SerializeDate;
    const PERMISSION_NAME = 'Activity-Log';
    public $can_search_by = ['user.name', 'description', 'subject_type'];

    public static function logsIndex()
    {
        $query = self::select([
            'activity_log.*',
            'user.name as user.name',
        ])
            ->join('users as user', 'activity_log.causer_id', '=', 'user.id')
            ->where('subject_type', '!=', 'App\Models\User');
//            ->where(function($inner){
//                $inner->where(function($inner2){
//                    $inner2->where('description', 'Logged in')->where('subject_type', 'App\Models\User');
//                })
//                    ->orWhere('subject_type', '!=', 'App\Models\User');
//            });

        $logs = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $logs->count();
        $logs = app(Pipeline::class)->send($logs)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $logs = $logs->with(['subject'])->get();
        $logs->map->formatObject();
        return Helpers::FormatForDatatable($logs, $count);
    }

    public function formatObject()
    {
        $this->action = $this->description;
        if ($this->description != 'Logged in') {
            $this->action .= ' ' . str_replace('App\\Models\\', '', $this->subject_type);
        }
        switch ($this->subject_type) {
            case JobFile::class:
                $this->action .= ' ' . $this->subject->file_no;
                break;
            case Hotel::class:
                $this->action .= ' ' . $this->subject->name;
                break;
            case Room::class:
                $this->action .= ' ' . $this->subject->name;
                break;
            case RoomDetails::class:
                $this->action .= ' ' . $this->subject->room->name;
                break;
            default:
                if ($this->subject) {
                    $this->action .= ' id:' . $this->subject->id;
                }
                break;
        }
        $this->user = (object)['name' => $this->{'user.name'}];
    }

    public static function logToDB($subject, $message)
    {
        activity()
            ->performedOn($subject)
            ->causedBy(auth()->user())
            ->log($message);
    }
}
