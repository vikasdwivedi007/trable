<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Queue\Jobs\Job;
use Spatie\Activitylog\Traits\LogsActivity;

class JobTitle extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    const GENERAL_MANAGER_TITLE = 'المدير العام';
    const VICE_GENERAL_MANAGER_TITLE = 'نائب المدير العام';
    const GUIDE_TITLE = 'Supplier-Guide';
    const REPRESENTATIVE_TITLE  = 'مندوب';
    const MANAGER_TITLE = 'مدير';
    const OPERATOR_TITLE = 'منظم برامج سياحية';

    public function employees()
    {
        return $this->hasMany(Employee::class, 'job_id');
    }

    public static function isGeneralManagerJob($id)
    {
        return self::where('name', self::GENERAL_MANAGER_TITLE)->where('id', $id)->count();
    }

    public static function handleJobIdAndTitle($data)
    {
        //if there's job_title but job_id is missing
        if ((!isset($data['job_id']) || !$data['job_id']) && isset($data['job_title']) && $data['job_title']) {
            $existing_job_title = JobTitle::where('title', $data['job_title'])->first();
            if ($existing_job_title) {
                $job_title = $existing_job_title;
            } else {
                $job_title = new JobTitle();
                $job_title->title = $data['job_title'];
                $job_title->can_be_assigned = 1;
                $job_title->save();
            }
            $data['job_id'] = $job_title->id;
        }
        //remove job_title anyway (because it's either converted to job_id or job_id was already_sent)
        unset($data['job_title']);
        return $data;
    }

    public static function managers_titles()
    {
        return [
            'المدير العام',
            'نائب المدير العام',
            'المدير المسئول',
            'مدير',
            'نائب مدير',
        ];
    }

}
