<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobGift extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['job_id', 'gift_id', 'gifts_count'];

    public function job()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}
