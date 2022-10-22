<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Discount extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $fillable = ['discount_type', 'discount_value'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    const TYPE_PERCENTAGE = 1;
    const TYPE_AMOUNT = 2;

    public function discountable()
    {
        return $this->morphTo();
    }

    public function setDiscountTypeAttribute($discount_type)
    {
        $this->attributes['type'] = $discount_type;
    }

    public function setDiscountValueAttribute($discount_value)
    {
        $this->attributes['value'] = $discount_value;
    }

}
