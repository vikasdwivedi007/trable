<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class DailySheet extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Daily-Sheets';

    protected $fillable = ['date', 'city_id'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date:l d F Y'
    ];

    public $can_search_by = ["city.name"];

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($sheet) {
            $sheet->job_files()->delete();
        });
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function job_files()
    {
        return $this->hasMany(DailySheetFile::class, 'daily_sheet_id');
    }

    public static function viewIndex()
    {
        $query = self::select([
            'daily_sheets.*',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'daily_sheets.city_id', '=', 'city.id');

        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $query->count();
        $query = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $daily_sheets = $query->get();
        $daily_sheets->map->formatObjectForDatatable();
        return Helpers::FormatForDatatable($daily_sheets, $count);
    }

    public function formatObjectForDatatable()
    {
        $this->city = (object)['name' => $this->{"city.name"}];
        $this->date = $this->date->format('l d F Y');
    }

    public function createOrUpdateFiles($data)
    {
        $this->job_files()->delete();
        if (isset($data['job_files']) && $data['job_files']) {
            foreach ($data['job_files'] as $job_file) {
                $this->job_files()->create($job_file);
            }
        }
    }

    public static function prepareData($data)
    {
        if (isset($data['job_files'])) {
            foreach ($data['job_files'] as $key => $job_file) {
                $job_file['job_id'] = JobFile::where('file_no', $job_file['file_no'])->first()->id;
                $data['job_files'][$key] = $job_file;
            }
        }
        return $data;
    }
}
