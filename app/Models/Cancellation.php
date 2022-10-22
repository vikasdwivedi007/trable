<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cancellation extends Model
{
    use SoftDeletes;

    protected $fillable = ['room_id', 'type', 'value', 'time'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
