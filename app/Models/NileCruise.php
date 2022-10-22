<?php

namespace App\Models;

use App\Helpers;
use App\Traits\AddCurrenciesToPrices;
use App\Traits\SaveInitialPrices;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class NileCruise extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Nile-Cruise';

    protected $fillable = ['company_name', 'name', 'rooms_count', 'rooms_type', 'adults_count', 'children_count', 'child_free_until', 'date_from', 'date_to', 'from_city_id', 'to_city_id', 'sgl_buy_price', 'sgl_sell_price', 'dbl_buy_price', 'dbl_sell_price', 'trpl_buy_price', 'trpl_sell_price', 'child_buy_price', 'child_sell_price', 'private_guide_salary', 'private_guide_accommodation', 'private_guide_buy_price', 'private_guide_sell_price', 'boat_guide_buy_price', 'boat_guide_sell_price',
        'sgl_buy_currency', 'sgl_sell_currency', 'dbl_buy_currency', 'dbl_sell_currency', 'trpl_buy_currency', 'trpl_sell_currency', 'child_buy_currency', 'child_sell_currency', 'private_buy_currency', 'private_sell_currency', 'boat_guide_buy_currency', 'boat_guide_sell_currency', 'cabin_type', 'deck_type', 'including_sightseeing'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['date_from', 'date_to'];
    protected $casts = [
        'date_from' => 'date:l d F Y',
        'date_to' => 'date:l d F Y',
    ];

    public $can_search_by = ['company_name', 'nile_cruises.name', 'cabin_type', 'from_city.name', 'to_city.name'];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($ticket) {
            $ticket->private_guide_buy_price = floatval($ticket->private_guide_salary) + floatval($ticket->private_guide_accommodation);
        });
    }

    public static function nileCruisesIndex()
    {
        $query = self::select([
            'nile_cruises.*',
            'from_city.name as from_city.name',
            'to_city.name as to_city.name',
        ])->join('cities as from_city', 'nile_cruises.from_city_id', '=', 'from_city.id')
            ->join('cities as to_city', 'nile_cruises.to_city_id', '=', 'to_city.id');

        $nile_cruises = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $nile_cruises->count();
        $nile_cruises = app(Pipeline::class)->send($nile_cruises)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $nile_cruises = $nile_cruises->with(['from_city', 'to_city'])->get();
        $nile_cruises->map->fillTypes();
        $nile_cruises->map->addCurrencyToPrices();
        $nile_cruises->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($nile_cruises, $count);
    }

    public function setDateFromAttribute($date_from)
    {
        $this->attributes['date_from'] = Carbon::createFromFormat('l d F Y', $date_from);
    }

    public function setDateToAttribute($date_to)
    {
        $this->attributes['date_to'] = Carbon::createFromFormat('l d F Y', $date_to);
    }

    public function from_city()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function to_city()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function job_cruises()
    {
        return $this->hasMany(JobCruise::class, 'cruise_id');
    }

    public function editPath()
    {
        return route('nile-cruises.edit', ['nile_cruise' => $this->id]);
    }

    public function deletePath()
    {
        return route('nile-cruises.destroy', ['nile_cruise' => $this->id]);
    }

    public static function room_types($key = 0)
    {
        $types = [
            1 => 'Single',
            2 => 'Double',
            3 => 'Triple',
            7 => 'Twin',
            8 => 'Suite',
        ];
        if ($key) {
            return isset($types[$key]) ? $types[$key] : null;
        } else {
            return $types;
        }
    }

    public static function searchForTypes($filter_q)
    {
        return Arr::where(self::room_types(), function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public function fillTypes()
    {
        $this->rooms_type = self::room_types($this->rooms_type);
    }

    public static function pricesFields()
    {
        return [
            'sgl_buy_price', 'sgl_sell_price', 'dbl_buy_price', 'dbl_sell_price', 'trpl_buy_price', 'trpl_sell_price', 'child_buy_price', 'child_sell_price', 'private_guide_salary', 'private_guide_accommodation', 'private_guide_buy_price', 'private_guide_sell_price', 'boat_guide_buy_price', 'boat_guide_sell_price'
        ];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'sgl_buy_price' => 'sgl_buy_currency',
            'sgl_sell_price' => 'sgl_sell_currency',
            'dbl_buy_price' => 'dbl_buy_currency',
            'dbl_sell_price' => 'dbl_sell_currency',
            'trpl_buy_price' => 'trpl_buy_currency',
            'trpl_sell_price' => 'trpl_sell_currency',
            'child_buy_price' => 'child_buy_currency',
            'child_sell_price' => 'child_sell_currency',
            'private_guide_salary' => 'private_buy_currency',
            'private_guide_accommodation' => 'private_buy_currency',
            'private_guide_buy_price' => 'private_buy_currency',
            'private_guide_sell_price' => 'private_sell_currency',
            'boat_guide_buy_price' => 'boat_guide_buy_currency',
            'boat_guide_sell_price' => 'boat_guide_sell_currency'
        ];
    }

    public function getAvailableRoomTypes()
    {
        $types = [];
        if (floatval($this->sgl_sell_price)) {
            $types[1] = 'Single';
        }
        if (floatval($this->dbl_sell_price)) {
            $types[2] = 'Double';
        }
        if (floatval($this->trpl_sell_price)) {
            $types[3] = 'Triple';
        }
        return $types;
    }
}
