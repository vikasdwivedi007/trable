<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('program_id');
            $table->bigInteger('program_itemable_id')->unsigned();
            $table->string('program_itemable_type');
            $table->dateTime('time_from')->nullable();
            $table->dateTime('time_to')->nullable();
            $table->tinyInteger('inc_sightseeing')->default(0);
            $table->tinyInteger('inc_private_guide')->default(0);
            $table->tinyInteger('inc_boat_guide')->default(0);
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
        Schema::dropIfExists('program_items');
    }
}
