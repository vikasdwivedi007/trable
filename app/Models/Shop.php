<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class Shop extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate;

    const PERMISSION_NAME = 'Shop';

    protected $fillable = ['name', 'city_id', 'phone', 'commission', 'address'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['shops.name', 'phone', 'address', 'city.name'];

    public static function shopsIndex()
    {
        $query = self::select([
            'shops.*',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'shops.city_id', '=', 'city.id');

        $shops = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $shops->count();
        $shops = app(Pipeline::class)->send($shops)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $shops = $shops->with('city')->get();
        $shops->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($shops, $count);
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function editPath()
    {
        return route('shops.edit', ['shop' => $this->id]);
    }

    public function deletePath()
    {
        return route('shops.destroy', ['shop' => $this->id]);
    }

    public function saveContract($contract)
    {
        if ($contract) {
            $data = File::uploadFile($contract, 'contracts', $this->id);
            if ($data) {
                $query = [
                    'fileable_id' => $this->id,
                    'fileable_type' => static::class
                ];
                $this->file()->updateOrCreate($query, $data);
            }
        }
    }
}
