<?php

namespace App\Traits;

use App\Models\Currency;

trait AddCurrenciesToPrices
{
    public function addCurrencyToPrices()
    {
        foreach (self::pricesFieldsWithCurrencies() as $price_field => $price_currency) {
            $currency = Currency::currencyName($this->{$price_currency});
            if ($this->{$price_field}) {
                $this->{$price_field} = $this->{$price_field} . ' ' . $currency;
            }
        }
        return $this;
    }
}
