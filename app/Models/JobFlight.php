<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobFlight extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'flight_id', 'type'];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
