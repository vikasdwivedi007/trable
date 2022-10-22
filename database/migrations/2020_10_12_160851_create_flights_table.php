<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('date');
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->timestamp('depart_at')->nullable();
            $table->timestamp('arrive_at')->nullable();
            $table->string('reference')->nullable()->default('');
            $table->integer('seats_count')->nullable()->default(0);
            $table->unsignedTinyInteger('status');
            $table->decimal('buy_price', 10, 2);
            $table->decimal('sell_price_vat_exc', 10, 2);
            $table->unsignedTinyInteger('buy_price_currency');
            $table->unsignedTinyInteger('sell_price_vat_exc_currency');
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
        Schema::dropIfExists('flights');
    }
}
