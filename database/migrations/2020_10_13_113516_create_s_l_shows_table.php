<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSLShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_l_shows', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('place');
            $table->unsignedInteger('language_id');
            $table->datetime('time');
            $table->string('ticket_type');
            $table->decimal('buy_price_adult', 10, 2);
            $table->decimal('sell_price_adult_vat_exc', 10, 2);
            $table->decimal('buy_price_child', 10, 2);
            $table->decimal('sell_price_child_vat_exc', 10, 2);
            $table->unsignedTinyInteger('adult_buy_currency');
            $table->unsignedTinyInteger('adult_sell_currency');
            $table->unsignedTinyInteger('child_buy_currency');
            $table->unsignedTinyInteger('child_sell_currency');

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
        Schema::dropIfExists('s_l_shows');
    }
}
