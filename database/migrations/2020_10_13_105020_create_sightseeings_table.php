<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSightseeingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sightseeings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('city_id');
            $table->text('desc')->nullable();
            $table->decimal('buy_price_adult', 10, 2);
            $table->decimal('sell_price_adult_vat_exc', 10, 2);
            $table->decimal('buy_price_child', 10, 2);
            $table->decimal('sell_price_child_vat_exc', 10, 2);
            $table->unsignedTinyInteger('buy_price_adult_currency');
            $table->unsignedTinyInteger('sell_price_adult_currency');
            $table->unsignedTinyInteger('buy_price_child_currency');
            $table->unsignedTinyInteger('sell_price_child_currency');
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
        Schema::dropIfExists('sightseeings');
    }
}
