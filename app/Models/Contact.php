<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, SerializeDate;

    protected $fillable = ['name', 'email', 'phone'];

    public function contactable()
    {
        return $this->morphTo();
    }
}
