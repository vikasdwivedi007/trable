<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherSerialized extends Model
{
    use SoftDeletes;

    protected $table = 'vouchers_serialized';

    public function vserialable(){
        return $this->morphTo();
    }
}
