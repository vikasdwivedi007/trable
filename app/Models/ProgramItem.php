<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramItem extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['program_id', 'program_itemable_id', 'program_itemable_type', 'time_from', 'time_to', 'inc_sightseeing', 'inc_private_guide', 'inc_boat_guide'];

    protected $dates = ['time_from', 'time_to'];
    protected $casts = [
        'time_from' => 'datetime:H:i',
        'time_to' => 'datetime:H:i',
    ];

    public function program_itemable()
    {
        return $this->morphTo();
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
