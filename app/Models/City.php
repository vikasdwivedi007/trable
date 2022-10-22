<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;

class City extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $table = 'cities';

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected static function boot()
    {
        parent::boot();

        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order_col', 'asc')->orderBy('name', 'asc');
        });
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public static function addCustomEgyptCitiesWithOrder()
    {
        $custom_cities = [
            'Cairo', 'Giza', 'Luxor', 'Aswan', 'Edfu', 'Kom Ombo', 'Alexandria', 'Hurghada', 'Sharm El-Sheikh', 'Marsa Alam', 'Abu Simbel'
        ];
        $i = 1;
        foreach ($custom_cities as $custom_city) {
            $exists = self::where('country_id', Country::EGYPT_ID)->where('name', $custom_city)->first();
            if (!$exists) {
                $city = new self();
                $city->name = $custom_city;
                $city->order_col = $i;
                $city->country_id = Country::EGYPT_ID;
                $city->save();
            } else {
                if ($exists->order_col != $i) {
                    $exists->order_col = $i;
                    $exists->save();
                }
            }
            $i++;
        }
    }

    public static function getRestaurantCities()
    {
        $cities = ['Cairo', 'Alexandria', 'Sharm El-Sheikh', 'Hurghada', 'Abu Simbel', 'Luxor', 'Aswan'];
        return self::where('country_id', Country::EGYPT_ID)->whereIn('name', $cities)->get();
    }

    public static function getEgyptianCities()
    {
        return self::where('country_id', Country::EGYPT_ID)->get();
    }
}
