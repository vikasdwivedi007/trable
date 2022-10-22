<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CruiseCabinItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['item_id', 'adults_count', 'children_count'];

    public function job_cruise()
    {
        return $this->belongsTo(JobCruise::class, 'item_id');
    }

    public function calculatePrice()
    {
        $base_price = 0;
        $total_price = 0;
        $room_type = NileCruise::room_types($this->job_cruise->room_type);
        $text = [$room_type.' Cabin'];
        if($this->adults_count){
            $text[] = $this->adults_count .' adult(s)';
        }
        if($this->children_count){
            $text[] = $this->children_count .' child(ren)';
        }
        $currency = '';
        if ($room_type == 'Single') {
            $base_price = $this->job_cruise->nile_cruise->sgl_sell_price;
            $currency = Currency::currencyName($this->job_cruise->nile_cruise->sgl_sell_currency);
        } elseif ($room_type == 'Double') {
            $base_price = $this->job_cruise->nile_cruise->dbl_sell_price;
            $currency = Currency::currencyName($this->job_cruise->nile_cruise->dbl_sell_currency);
        } elseif ($room_type == 'Triple') {
            $base_price = $this->job_cruise->nile_cruise->trpl_sell_price;
            $currency = Currency::currencyName($this->job_cruise->nile_cruise->trpl_sell_currency);
        }
        $total_price = $base_price;

        if($this->job_cruise->inc_private_guide){
            $text[] = 'Including Private Guide';
            $total_price += $this->job_cruise->nile_cruise->private_guide_sell_price;
        }
        if($this->job_cruise->inc_boat_guide){
            $text[] = 'Including Boat Guide';
            $total_price += $this->job_cruise->nile_cruise->boat_guide_sell_price;
        }

        return [ join(', ',$text), $total_price, $currency];
    }
}
