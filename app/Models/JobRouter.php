<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobRouter extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'router_id', 'days_count'];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function router()
    {
        return $this->belongsTo(Router::class);
    }
}
