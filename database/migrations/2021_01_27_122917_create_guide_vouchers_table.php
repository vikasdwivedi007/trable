<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serial_no')->nullable();
            $table->unsignedBigInteger('job_id');
            $table->string('issued_by');
            $table->unsignedBigInteger('guide_id');
            $table->string('guide_address')->nullable();
            $table->unsignedBigInteger('hotel_id');
            $table->string('room_no')->nullable();
            $table->string('transport_by')->nullable();
            $table->integer('pax_no');
            $table->string('tour_operator');
            $table->date('issue_date');
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
        Schema::dropIfExists('guide_vouchers');
    }
}
