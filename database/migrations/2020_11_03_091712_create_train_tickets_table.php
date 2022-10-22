<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_tickets', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->string('number');
            $table->string('wagon_no');
            $table->string('seat_no');
            $table->tinyInteger('class');
            $table->unsignedTinyInteger('currency');
            $table->decimal('sgl_buy_price', 10, 2)->nullable()->default(0);
            $table->decimal('sgl_sell_price', 10, 2)->nullable()->default(0);
            $table->decimal('dbl_buy_price', 10, 2)->nullable()->default(0);
            $table->decimal('dbl_sell_price', 10, 2)->nullable()->default(0);
            $table->unsignedInteger('from_station_id');
            $table->unsignedInteger('to_station_id');
            $table->dateTime('depart_at');
            $table->dateTime('arrive_at');
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
        Schema::dropIfExists('train_tickets');
    }
}
