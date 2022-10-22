<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobGuide extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'city_id', 'guide_id', 'sightseeing_id', 'date'];

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime:l d F Y'
    ];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function guide(){
        return $this->belongsTo(Guide::class);
    }

    public function sightseeing(){
        return $this->belongsTo(Sightseeing::class);
    }
}
