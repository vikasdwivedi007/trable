<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no');
            $table->tinyInteger('provider');
            $table->integer('number');
            $table->integer('quota');
            $table->unsignedInteger('city_id');
            $table->decimal('package_buy_price', 10, 2);
            $table->decimal('package_sell_price_vat_exc', 10, 2);
            $table->unsignedTinyInteger('package_buy_currency');
            $table->unsignedTinyInteger('package_sell_currency');
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
        Schema::dropIfExists('routers');
    }
}
