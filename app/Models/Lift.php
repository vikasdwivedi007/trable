<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lift extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['time', 'details'];

    protected $dates = ['time'];
    protected $casts = [
        'time' => 'datetime:H:i'
    ];

    public function program_itemable()
    {
        return $this->morphOne(ProgramItem::class, 'program_itemable');
    }

}
