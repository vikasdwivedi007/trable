<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsInTrainTicketsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('train_tickets', function (Blueprint $table) {
            $table->string('number')->nullable()->change();
            $table->string('wagon_no')->nullable()->change();
            $table->string('seat_no')->nullable()->change();
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
            $table->string('number')->change();
            $table->string('wagon_no')->change();
            $table->string('seat_no')->change();
        });
    }
}
