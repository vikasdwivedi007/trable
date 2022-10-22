<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelVoucherMeal extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['voucher_id', 'date', 'american_breakfast', 'continental_breakfast', 'lunch', 'dinner'];

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime:l d F Y',
    ];

    public function voucher()
    {
        return $this->belongsTo(HotelVoucher::class, 'voucher_id');
    }
}
