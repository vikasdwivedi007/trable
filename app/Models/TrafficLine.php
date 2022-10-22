<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TrafficLine extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $fillable = ["police_permission_id", "date", "details"];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime:l d F Y H:i'
    ];

    public function policePermission()
    {
        return $this->belongsTo(PolicePermission::class, 'police_permission_id');
    }

}
