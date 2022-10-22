<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Language extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [ 'created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    const ALL_LANGUAGES_ID = 1000;
}
