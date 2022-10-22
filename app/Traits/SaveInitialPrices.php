<?php

namespace App\Traits;

trait SaveInitialPrices
{
    public static function bootSaveInitialPrices()
    {
        static::saving(function ($model) {
            if(method_exists($model, 'pricesFields')){
                foreach (static::pricesFields() as $field) {
                    if (!$model->{$field}) {
                        $model->{$field} = 0;
                    }
                }
            }
        });
    }
}
