<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVisa extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'visa_id', 'visas_count'];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function visa()
    {
        return $this->belongsTo(TravelVisa::class, 'visa_id');
    }
}
