<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class RoomDetails extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $fillable = ['room_id', 'base_rate', 'base_rate_currency', 'price_valid_from', 'price_valid_to', 'extra_bed_exc', 'child_free_until', 'child_with_two_parents_exc', 'max_children_with_two_parents', 'single_parent_exc', 'single_parent_child_exc', 'min_child_age', 'max_child_age', 'special_offer'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['price_valid_from', 'price_valid_to'];

    protected $casts = [
        'price_valid_from' => 'date:l d F Y',
        'price_valid_to' => 'date:l d F Y'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
