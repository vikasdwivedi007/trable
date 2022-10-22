<?php

namespace App\Models;

use App\Traits\AddCurrenciesToPrices;
use App\Traits\SaveInitialPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class RestaurantMenu extends Model
{
    use SoftDeletes, LogsActivity, SaveInitialPrices, AddCurrenciesToPrices;

    protected $table = 'restaurant_menus';

    const PERMISSION_NAME = 'Restaurant';

    protected $fillable = ['name', 'buy_price', 'sell_price_vat_exc', 'items', 'buy_currency', 'sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public static function pricesFields()
    {
        return ['buy_price', 'sell_price_vat_exc'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'buy_price' => 'buy_currency',
            'sell_price_vat_exc' => 'sell_currency'
        ];
    }
}
