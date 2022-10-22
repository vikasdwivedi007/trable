<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFileReview extends Model
{
    use SoftDeletes;

    protected $fillable = ['job_id', 'reviewed_by', 'status'];

    const PERMISSION_NAME = 'Review/Approve Job-File';

    const STATUS_NOT_YET = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;

    public static function available_status(){
        return [self::STATUS_NOT_YET, self::STATUS_APPROVED, self::STATUS_DECLINED];
    }

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function reviewed_by_emp(){
        return $this->belongsTo(Employee::class, 'reviewed_by');
    }
}
