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
use Illuminate\Support\Str;
use PHPUnit\TextUI\Help;
use Spatie\Activitylog\Traits\LogsActivity;

class Sightseeing extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Excursion';

    protected $fillable = ['name', 'city_id', 'desc', 'buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc', 'buy_price_adult_currency', 'sell_price_adult_currency', 'buy_price_child_currency', 'sell_price_child_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['sightseeings.name', 'desc', 'city.name'];

    public static function sightseeingsIndex()
    {
        $query = self::select([
            'sightseeings.*',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'sightseeings.city_id', '=', 'city.id');

        $sightseeings = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $sightseeings->count();
        $sightseeings = app(Pipeline::class)->send($sightseeings)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $sightseeings = $sightseeings->with('city')->get();
        $sightseeings->map->trimDesc();
        $sightseeings->map->addCurrencyToPrices();
        $sightseeings->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($sightseeings, $count);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function program_itemable()
    {
        return $this->morphOne(ProgramItem::class, 'program_itemable');
    }

    public function editPath()
    {
        return route('sightseeings.edit', ['sightseeing' => $this->id]);
    }

    public function deletePath()
    {
        return route('sightseeings.destroy', ['sightseeing' => $this->id]);
    }

    public function trimDesc()
    {
        $this->desc = Str::limit($this->desc, 30);
    }

    public static function pricesFields()
    {
        return ['buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'buy_price_adult' => 'buy_price_adult_currency',
            'sell_price_adult_vat_exc' => 'sell_price_adult_currency',
            'buy_price_child' => 'buy_price_child_currency',
            'sell_price_child_vat_exc' => 'sell_price_child_currency'
        ];
    }

}
