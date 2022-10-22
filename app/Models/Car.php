<?php

namespace App\Models;

use App\Traits\AddCurrenciesToPrices;
use App\Traits\SaveInitialPrices;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Car extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Transportation';

    protected $fillable = ['driver_name', 'driver_name_ar', 'driver_phone', 'driver_no', 'car_type', 'car_model', 'car_no', 'buy_price', 'sell_price_vat_exc', 'buy_currency', 'sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
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
