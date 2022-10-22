<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVBNightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_b_nights', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('city_id');
            $table->decimal('buy_price_adult', 10, 2);
            $table->decimal('sell_price_adult_vat_exc', 10, 2);
            $table->decimal('buy_price_child', 10, 2);
            $table->decimal('sell_price_child_vat_exc', 10, 2);
            $table->unsignedTinyInteger('adult_buy_currency');
            $table->unsignedTinyInteger('adult_sell_currency');
            $table->unsignedTinyInteger('child_buy_currency');
            $table->unsignedTinyInteger('child_sell_currency');

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
        Schema::dropIfExists('v_b_nights');
    }
}
