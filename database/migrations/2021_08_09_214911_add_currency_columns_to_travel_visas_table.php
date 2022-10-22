<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToTravelVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel_visas', function (Blueprint $table) {
            if (Schema::hasColumn('travel_visas', 'currency')) {
                $table->dropColumn('currency');
            }
            if (!Schema::hasColumn('travel_visas', 'buy_currency')) {
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
        Schema::table('travel_visas', function (Blueprint $table) {
            if (!Schema::hasColumn('travel_visas', 'currency')) {
                $table->unsignedTinyInteger('currency')->default(1);
            }
            if (Schema::hasColumn('travel_visas', 'buy_currency')) {
                $table->dropColumn('buy_currency');
                $table->dropColumn('sell_currency');
            }
        });
    }
}
