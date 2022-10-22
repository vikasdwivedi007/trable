<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuideUnavailableAt extends Model
{
    use SerializeDate;

    protected $table = 'guide_unavailable_at';

    protected $fillable = ['guide_id', 'day'];

    protected $dates = ['day'];

    protected $casts = [
        'day' => 'date:l d F Y'
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }
}
