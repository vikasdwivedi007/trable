<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('draft_invoice_id');
            $table->string('details');
            $table->decimal('price_without_vat', 10, 2)->default(0)->nullable();
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->decimal('vat', 4, 2)->default(0)->nullable();
            $table->tinyInteger('currency');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_invoice_items');
    }
}
