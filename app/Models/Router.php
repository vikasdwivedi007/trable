<?php

namespace App\Models;

use App\Helpers;
use App\Traits\AddCurrenciesToPrices;
use App\Traits\SaveInitialPrices;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class Router extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Router';

    protected $fillable = ['serial_no', 'provider', 'number', 'quota', 'city_id', 'package_buy_price', 'package_sell_price_vat_exc', 'package_buy_currency', 'package_sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['city.name', 'serial_no', 'provider'];

    public static function providers($key = 0)
    {
        $types = [
            1 => 'Etisalat',
            2 => 'Orange',
            3 => 'Vodafone',
            4 => 'WE',
        ];
        if ($key) {
            return isset($types[$key]) ? $types[$key] : null;
        } else {
            return $types;
        }
    }

    public static function routersIndex()
    {
        $query = self::select([
            'routers.*',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'routers.city_id', '=', 'city.id');

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
                \App\QueryFilters\Paginate::class
            ])
            ->thenReturn();

        $routers = $query->with('city')->get();
        $routers->map->fillProviderName();
        $routers->map->addCurrencyToPrices();
        $routers->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($routers, $count);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function routers_in_jobs()
    {
        return $this->hasMany(JobRouter::class);
    }

    public function editPath()
    {
        return route('routers.edit', ['router' => $this->id]);
    }

    public function deletePath()
    {
        return route('routers.destroy', ['router' => $this->id]);
    }

    public static function searchForProviders($filter_q)
    {
        return Arr::where(self::providers(), function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public function fillProviderName()
    {
        $this->provider = self::providers($this->provider);
    }

    public static function pricesFields()
    {
        return ['package_buy_price', 'package_sell_price_vat_exc'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'package_buy_price' => 'package_buy_currency',
            'package_sell_price_vat_exc' => 'package_sell_currency'
        ];
    }

    public static function availableRouters($from, $to, $job_id = null)
    {
        $routers = self::where(function ($main_query) use ($from, $to, $job_id) {
            $main_query->whereDoesntHave('routers_in_jobs', function ($query) use ($from, $to) {
                $query->whereHas('job', function ($query2) use ($from, $to) {
                    $query2->where(function ($query3) use ($from, $to) {
                        $query3->where('departure_date', '>=', $from)
                            ->where('departure_date', '<=', $to);
                    });
                    $query2->orWhere(function ($query3) use ($from, $to) {
                        $query3->where('arrival_date', '>=', $from)
                            ->where('arrival_date', '<=', $to);
                    });
                    $query2->orWhere(function ($query3) use ($from, $to) {
                        $query3->where('arrival_date', '<=', $from)
                            ->where('departure_date', '>=', $to);
                    });
                });
            });
            if ($job_id) {
                $main_query->orwhereHas('routers_in_jobs', function ($query) use ($job_id) {
                    $query->where('job_id', $job_id);
                });
            }
        })->get();
        $routers->map(function ($router) {
            $router->currency_str = Currency::currencyName($router->package_sell_currency);
        });
        return $routers;
    }
}
