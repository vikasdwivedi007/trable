<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Ramsey\Uuid\Guid\Guid;
use Spatie\Activitylog\Traits\LogsActivity;

class PolicePermission extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Police-Permission';

    protected $fillable = ["job_id", "transportation_id", "guide_id", "representative_id", "driver_id", "car_no", "travel_agent_ar", "client_name_ar", "coming_from_ar", "nationality_ar"];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ["travel_agent.name", "job_file.file_no", "job_file.client_name", "job_file.arrival_date", "job_file.departure_date", "transportation.name", "driver.driver_name", "guide.name", "representative_user.name"];

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class, 'transportation_id');
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function driver()
    {
        return $this->belongsTo(Car::class, 'driver_id');
    }

    public function representative()
    {
        return $this->belongsTo(Employee::class, 'representative_id');
    }

    public function traffic_lines()
    {
        return $this->hasMany(TrafficLine::class, 'police_permission_id');
    }

    public static function permissionsIndex()
    {
        $query = self::select([
            'police_permissions.*',
            'job_file.file_no as job_file.file_no',
            'job_file.arrival_date as job_file.arrival_date',
            'job_file.departure_date as job_file.departure_date',
            'job_file.client_name as job_file.client_name',
            'travel_agent.name as travel_agent.name',
            'transportation.name as transportation.name',
            'driver.driver_name as driver.driver_name',
            'guide.name as guide.name',
            'representative.user_id as representative.user_id',
            'representative_user.name as representative_user.name'
        ])->leftJoin('job_files as job_file', 'police_permissions.job_id', '=', 'job_file.id')
            ->leftJoin('transportations as transportation', 'police_permissions.transportation_id', '=', 'transportation.id')
            ->leftJoin('cars as driver', 'police_permissions.driver_id', '=', 'driver.id')
            ->leftJoin('guides as guide', 'police_permissions.guide_id', '=', 'guide.id')
            ->leftJoin('employees as representative', 'police_permissions.representative_id', '=', 'representative.id')
            ->join('users as representative_user', 'representative.user_id', '=', 'representative_user.id')
            ->join('travel_agents as travel_agent', 'job_file.travel_agent_id', '=', 'travel_agent.id');

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
        $permissions = $query->with(['job_file', 'transportation', 'guide', 'driver',])->get();
        $permissions->map->formatObject();
        return Helpers::FormatForDatatable($permissions, $count);
    }

    public function addTrafficLines($data)
    {
        if (isset($data['traffic_lines'])) {
            $this->traffic_lines()->delete();
            $this->traffic_lines()->createMany($data['traffic_lines']);
        }
    }

    public function formatObject()
    {
        $this->travel_agent = (object)['name' => $this->{'travel_agent.name'}];
        $this->car = (object)['driver_name' => $this->{'driver.driver_name'}];
        $this->representative_user = (object)['name' => $this->{'representative_user.name'}];
        $this->transportation = (object)['name' => $this->{'transportation.name'}];
    }
}
