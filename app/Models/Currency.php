<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    protected $fillable = ['code', 'rate'];
    const USD = 1;
    const EURO = 2;
    const EGP = 3;

    public static function currencyName($currency = 0, $sign = false)
    {
        $currencies = self::availableCurrencies($sign);
        if ($currency) {
            if (isset($currencies[$currency])) {
                return $currencies[$currency];
            } elseif (isset(self::availableCurrenciesNames()[$currency])) {
                return self::availableCurrenciesNames()[$currency];
            }
        }
        return $currencies;
    }

    public static function availableCurrencies($sign = false)
    {
        return [
            self::USD => $sign ? '$' : 'USD',
            self::EURO => $sign ? '€' : 'EURO',
            self::EGP => $sign ? 'LE' : 'EGP',
        ];
    }

    public static function availableCurrenciesNames()
    {
        return [
            'USD' => 'USD',
            'EURO' => 'EURO',
            'EGP' => 'EGP',
        ];
    }

    public static function insertBaseData()
    {
        if (self::query()->whereIn('code', ['USD', 'EURO', 'EGP'])->count() != 3) {
            foreach (self::availableCurrencies() as $key => $code) {
                self::query()->updateOrCreate(['code' => $code], ['rate' => '1']);
            }
        }
    }

    public static function updateRates()
    {
        self::insertBaseData();
        $url = 'https://freecurrencyapi.net/api/v2/latest?apikey=9cf092f0-4ebb-11ec-a02b-83f6b082644a&base_currency=EGP';
        $response = Http::get($url);
        $result = json_decode($response->body(), true);
        if (isset($result['data']['USD'])) {
            self::query()->updateOrCreate(['code' => 'USD'], ['rate' => $result['data']['USD']]);
        }
        if (isset($result['data']['EUR'])) {
            self::query()->updateOrCreate(['code' => 'EURO'], ['rate' => $result['data']['EUR']]);
        }
    }

    public static function convertCurrency($from, $to, $amount)
    {
        if ($from == $to) {
            return $amount;
        }

        if ($from == 'EGP') {
            $to_row = self::query()->where('code', $to)->first();
            if ($to_row) {
                return $amount * $to_row->rate;
            } else {
                return false;
            }
        } elseif ($to == 'EGP') {
            $from_row = self::query()->where('code', $from)->first();
            if ($from_row) {
                return $amount * (1 / $from_row->rate);
            } else {
                return false;
            }
        } else {
            $from_row = self::query()->where('code', $from)->first();
            $to_row = self::query()->where('code', $to)->first();
            if ($from_row && $to_row) {
                return $amount * ($to_row->rate / $from_row->rate);
            } else {
                return false;
            }
        }
    }
}
