<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transportation_id');
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('driver_no');
            $table->string('car_type');
            $table->string('car_model');
            $table->string('car_no');
            $table->decimal('buy_price', 10, 2);
            $table->decimal('sell_price_vat_exc', 10, 2);
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
        Schema::dropIfExists('cars');
    }
}
