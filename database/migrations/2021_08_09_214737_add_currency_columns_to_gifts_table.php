<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gifts', function (Blueprint $table) {
            if (Schema::hasColumn('gifts', 'currency')) {
                $table->dropColumn('currency');
            }
            if (!Schema::hasColumn('gifts', 'buy_currency')) {
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
        Schema::table('gifts', function (Blueprint $table) {
            if (!Schema::hasColumn('gifts', 'currency')) {
                $table->unsignedTinyInteger('currency')->default(1);
            }
            if (Schema::hasColumn('gifts', 'buy_currency')) {
                $table->dropColumn('buy_currency');
                $table->dropColumn('sell_currency');
            }
        });
    }
}
