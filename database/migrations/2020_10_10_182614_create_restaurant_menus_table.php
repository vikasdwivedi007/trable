<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('restaurant_id');
            $table->string('name');
            $table->decimal('buy_price', 10, 2);
            $table->decimal('sell_price_vat_exc', 10, 2);
            $table->text('items');
            $table->unsignedTinyInteger('buy_currency');
            $table->unsignedTinyInteger('sell_currency');
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
        Schema::dropIfExists('restaurant_menus');
    }
}
