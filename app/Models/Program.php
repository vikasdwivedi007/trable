<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'day', 'city_id'];

    protected $dates = ['day'];
    protected $casts = [
        'day' => 'datetime:l d F Y'
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($program) {
            $program->items()->delete();
        });
    }

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function items()
    {
        return $this->hasMany(ProgramItem::class);
    }
}
