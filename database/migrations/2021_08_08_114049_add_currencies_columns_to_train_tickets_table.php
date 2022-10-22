<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrenciesColumnsToTrainTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('train_tickets', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->unsignedTinyInteger('sgl_buy_currency')->default(1);
            $table->unsignedTinyInteger('sgl_sell_currency')->default(1);
            $table->unsignedTinyInteger('dbl_buy_currency')->default(1);
            $table->unsignedTinyInteger('dbl_sell_currency')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('train_tickets', function (Blueprint $table) {
            $table->unsignedTinyInteger('currency');
            $table->dropColumn('sgl_buy_currency');
            $table->dropColumn('sgl_sell_currency');
            $table->dropColumn('dbl_buy_currency');
            $table->dropColumn('dbl_sell_currency');
        });
    }
}
