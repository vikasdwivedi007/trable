<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFileDelegation extends Model
{
    use SoftDeletes;

    protected $fillable = ['job_id', 'assigned_by', 'assigned_to'];

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function assigned_by_emp(){
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    public function assigned_to_emp(){
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
