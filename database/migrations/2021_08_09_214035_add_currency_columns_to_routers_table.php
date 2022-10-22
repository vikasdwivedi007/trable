<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToRoutersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routers', function (Blueprint $table) {
            if (Schema::hasColumn('routers', 'currency')) {
                $table->dropColumn('currency');
            }
            if (!Schema::hasColumn('routers', 'package_buy_currency')) {
                $table->unsignedTinyInteger('package_buy_currency')->default(1);
                $table->unsignedTinyInteger('package_sell_currency')->default(1);
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
        Schema::table('routers', function (Blueprint $table) {
            if (!Schema::hasColumn('routers', 'currency')) {
                $table->unsignedTinyInteger('currency')->default(1);
            }
            if (Schema::hasColumn('routers', 'package_buy_currency')) {
                $table->dropColumn('package_buy_currency');
                $table->dropColumn('package_sell_currency');
            }
        });
    }
}
