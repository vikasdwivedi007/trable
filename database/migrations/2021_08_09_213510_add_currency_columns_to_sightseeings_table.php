<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToSightseeingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sightseeings', function (Blueprint $table) {
            if (Schema::hasColumn('sightseeings', 'currency')) {
                $table->dropColumn('currency');
            }
            if (!Schema::hasColumn('sightseeings', 'buy_price_adult_currency')) {
                $table->unsignedTinyInteger('buy_price_adult_currency')->default(1);
                $table->unsignedTinyInteger('sell_price_adult_currency')->default(1);
                $table->unsignedTinyInteger('buy_price_child_currency')->default(1);
                $table->unsignedTinyInteger('sell_price_child_currency')->default(1);
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
        Schema::table('sightseeings', function (Blueprint $table) {
            if (!Schema::hasColumn('sightseeings', 'currency')) {
                $table->unsignedTinyInteger('currency')->default(1);
            }
            if (Schema::hasColumn('sightseeings', 'buy_price_adult_currency')) {
                $table->dropColumn('buy_price_adult_currency');
                $table->dropColumn('sell_price_adult_currency');
                $table->dropColumn('buy_price_child_currency');
                $table->dropColumn('sell_price_child_currency');
            }
        });
    }
}
