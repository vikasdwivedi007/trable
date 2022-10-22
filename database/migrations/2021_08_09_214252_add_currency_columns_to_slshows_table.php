<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToSlshowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_l_shows', function (Blueprint $table) {
            if (Schema::hasColumn('s_l_shows', 'currency')) {
                $table->dropColumn('currency');
            }
            if (!Schema::hasColumn('s_l_shows', 'adult_buy_currency')) {
                $table->unsignedTinyInteger('adult_buy_currency')->default(1);
                $table->unsignedTinyInteger('adult_sell_currency')->default(1);
                $table->unsignedTinyInteger('child_buy_currency')->default(1);
                $table->unsignedTinyInteger('child_sell_currency')->default(1);
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
        Schema::table('s_l_shows', function (Blueprint $table) {
            if (!Schema::hasColumn('s_l_shows', 'currency')) {
                $table->unsignedTinyInteger('currency')->default(1);
            }
            if (Schema::hasColumn('s_l_shows', 'adult_buy_currency')) {
                $table->dropColumn('adult_buy_currency');
                $table->dropColumn('adult_sell_currency');
                $table->dropColumn('child_buy_currency');
                $table->dropColumn('child_sell_currency');
            }
        });
    }
}
