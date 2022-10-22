<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobAccommodation extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'hotel_id', 'room_id', 'room_type', 'meal_plan', 'category', 'view', 'check_in', 'check_out', 'situation', 'payment_date', 'voucher_date'];

    protected $dates = ['check_in', 'check_out', 'payment_date', 'voucher_date'];
    protected $casts = [
        'check_in' => 'datetime:l d F Y',
        'check_out' => 'datetime:l d F Y',
        'payment_date' => 'datetime:l d F Y',
        'voucher_date' => 'datetime:l d F Y',
    ];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
