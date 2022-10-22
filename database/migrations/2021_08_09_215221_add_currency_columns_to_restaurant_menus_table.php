<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToRestaurantMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_menus', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurant_menus', 'buy_currency')) {
                $table->unsignedTinyInteger('buy_currency')->default(1);
                $table->unsignedTinyInteger('sell_currency')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_menus', function (Blueprint $table) {
            if (Schema::hasColumn('restaurant_menus', 'buy_currency')) {
                $table->dropColumn('buy_currency');
                $table->dropColumn('sell_currency');
            }
        });
    }
}
