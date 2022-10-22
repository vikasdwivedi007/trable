<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuideVoucherTour extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['voucher_id', 'date', 'desc'];

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime:l d F Y H:i',
    ];

    public function voucher()
    {
        return $this->belongsTo(GuideVoucher::class, 'voucher_id');
    }
}
