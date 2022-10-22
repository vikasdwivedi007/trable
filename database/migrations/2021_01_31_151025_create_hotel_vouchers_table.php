<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serial_no')->nullable();
            $table->unsignedBigInteger('job_id');
            $table->string('issued_by');
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->unsignedBigInteger('cruise_id')->nullable();
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->string('single_rooms_count')->nullable();
            $table->string('double_rooms_count')->nullable();
            $table->string('triple_rooms_count')->nullable();
            $table->string('suite_rooms_count')->nullable();
            $table->text('remarks');
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
        Schema::dropIfExists('hotel_vouchers');
    }
}
