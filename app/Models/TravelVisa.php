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

class TravelVisa extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Travel-Visa';

    protected $fillable = ['name', 'buy_price', 'sell_price', 'buy_currency', 'sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['name', 'buy_price', 'sell_price'];

    public static function travelVisasIndex()
    {
        $query = self::select([
            'travel_visas.*',
        ]);

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

        $visas = $query->get();
        $visas->map->addCurrencyToPrices();
        $visas->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($visas, $count);
    }

    public function job_visas()
    {
        return $this->hasMany(JobVisa::class, 'visa_id');
    }

    public static function pricesFields()
    {
        return ['buy_price', 'sell_price'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'buy_price' => 'buy_currency',
            'sell_price' => 'sell_currency'
        ];
    }
}
