<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_accommodations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('room_id')->nullable();
            $table->tinyInteger('room_type');
            $table->tinyInteger('meal_plan');
            $table->string('category');
            $table->string('view');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->string('situation');
            $table->dateTime('payment_date')->nullable();
            $table->dateTime('voucher_date')->nullable();
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
        Schema::dropIfExists('job_accommodations');
    }
}
