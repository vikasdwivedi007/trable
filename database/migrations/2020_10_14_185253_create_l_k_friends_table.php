<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLKFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_k_friends', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->unsignedInteger('city_id');
            $table->decimal('rent_day', 10, 2)->nullable();
            $table->unsignedTinyInteger('rent_day_currency');
            $table->decimal('sell_rent_day_vat_exc', 10, 2)->nullable();
            $table->unsignedTinyInteger('sell_rent_day_currency');
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
        Schema::dropIfExists('l_k_friends');
    }
}
