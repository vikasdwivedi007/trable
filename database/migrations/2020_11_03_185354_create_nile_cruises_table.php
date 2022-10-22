<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNileCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nile_cruises', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('name');

            $table->date('date_from');
            $table->date('date_to');
            $table->unsignedInteger('from_city_id');
            $table->unsignedInteger('to_city_id');

            $table->string('cabin_type');
            $table->string('deck_type');
            $table->tinyInteger('including_sightseeing');

            $table->unsignedTinyInteger('sgl_buy_currency');
            $table->unsignedTinyInteger('sgl_sell_currency');
            $table->unsignedTinyInteger('dbl_buy_currency');
            $table->unsignedTinyInteger('dbl_sell_currency');
            $table->unsignedTinyInteger('trpl_buy_currency');
            $table->unsignedTinyInteger('trpl_sell_currency');
            $table->unsignedTinyInteger('child_buy_currency');
            $table->unsignedTinyInteger('child_sell_currency');
            $table->unsignedTinyInteger('private_buy_currency');
            $table->unsignedTinyInteger('private_sell_currency');
            $table->unsignedTinyInteger('boat_guide_buy_currency');
            $table->unsignedTinyInteger('boat_guide_sell_currency');

            $table->decimal('sgl_buy_price', 10, 2)->nullable();
            $table->decimal('sgl_sell_price', 10, 2)->nullable();
            $table->decimal('dbl_buy_price', 10, 2)->nullable();
            $table->decimal('dbl_sell_price', 10, 2)->nullable();
            $table->decimal('trpl_buy_price', 10, 2)->nullable();
            $table->decimal('trpl_sell_price', 10, 2)->nullable();
            $table->decimal('child_buy_price', 10, 2)->nullable();
            $table->decimal('child_sell_price', 10, 2)->nullable();

            $table->decimal('private_guide_salary', 10, 2)->nullable();
            $table->decimal('private_guide_accommodation', 10, 2)->nullable();
            $table->decimal('private_guide_buy_price', 10, 2)->nullable();
            $table->decimal('private_guide_sell_price', 10, 2)->nullable();
            $table->decimal('boat_guide_buy_price', 10, 2)->nullable();
            $table->decimal('boat_guide_sell_price', 10, 2)->nullable();

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
        Schema::dropIfExists('nile_cruises');
    }
}
