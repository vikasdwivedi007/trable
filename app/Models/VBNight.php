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
use Spatie\Activitylog\Traits\LogsActivity;

class VBNight extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Visit-By-Night';

    protected $fillable = ['name', 'city_id', 'buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc', 'adult_buy_currency', 'adult_sell_currency', 'child_buy_currency', 'child_sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['v_b_nights.name', 'city.name'];

    public static function vbnightsIndex()
    {
        $query = self::select([
            'v_b_nights.*',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'v_b_nights.city_id', '=', 'city.id');

        $vbnights = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $vbnights->count();
        $vbnights = app(Pipeline::class)->send($vbnights)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $vbnights = $vbnights->with('city')->get();
        $vbnights->map->addCurrencyToPrices();
        $vbnights->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($vbnights, $count);
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
        return route('vbnights.edit', ['vbnight' => $this->id]);
    }

    public function deletePath()
    {
        return route('vbnights.destroy', ['vbnight' => $this->id]);
    }

    public static function pricesFields()
    {
        return ['buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'buy_price_adult' => 'adult_buy_currency',
            'sell_price_adult_vat_exc' => 'adult_sell_currency',
            'buy_price_child' => 'child_buy_currency',
            'sell_price_child_vat_exc' => 'child_sell_currency'
        ];
    }

    public function formatObject()
    {

    }
}
