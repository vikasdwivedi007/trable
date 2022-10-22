<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCruise extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'cruise_id', 'room_type', 'inc_private_guide', 'inc_boat_guide'];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($job_cruise) {
            $job_cruise->cabins()->delete();
        });
    }

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function nile_cruise()
    {
        return $this->belongsTo(NileCruise::class, 'cruise_id');
    }

    public function cabins()
    {
        return $this->hasMany(CruiseCabinItem::class, 'item_id');
    }
}
