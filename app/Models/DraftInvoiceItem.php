<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DraftInvoiceItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['draft_invoice_id', 'details', 'price_without_vat', 'price', 'vat', 'currency'];

    public function draft_invoice()
    {
        return $this->belongsTo(DraftInvoice::class, 'draft_invoice_id');
    }
}
