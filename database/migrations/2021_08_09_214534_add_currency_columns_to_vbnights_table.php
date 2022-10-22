<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToVbnightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v_b_nights', function (Blueprint $table) {
            if (Schema::hasColumn('v_b_nights', 'currency')) {
                $table->dropColumn('currency');
            }
            if (!Schema::hasColumn('v_b_nights', 'adult_buy_currency')) {
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
        Schema::table('v_b_nights', function (Blueprint $table) {
            if (!Schema::hasColumn('v_b_nights', 'currency')) {
                $table->unsignedTinyInteger('currency')->default(1);
            }
            if (Schema::hasColumn('v_b_nights', 'adult_buy_currency')) {
                $table->dropColumn('adult_buy_currency');
                $table->dropColumn('adult_sell_currency');
                $table->dropColumn('child_buy_currency');
                $table->dropColumn('child_sell_currency');
            }
        });
    }
}
