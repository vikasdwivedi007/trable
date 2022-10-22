<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class DailySheetFile extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Daily-Sheets';

    protected $fillable = ['daily_sheet_id', 'job_id', 'pnr', 'router_number', 'concierge', 'remarks', 'itinerary', 'transportation_id', 'representative_id', 'driver_name', 'driver_phone'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = [];

    public function daily_sheet()
    {
        return $this->belongsTo(DailySheet::class, 'daily_sheet_id');
    }

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function representative()
    {
        return $this->belongsTo(Employee::class, 'representative_id');
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class, 'transportation_id');
    }
}
