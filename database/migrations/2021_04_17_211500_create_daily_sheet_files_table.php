<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySheetFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sheet_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_sheet_id');
            $table->unsignedBigInteger('job_id');
            $table->string('pnr')->nullable();
            $table->string('router_number')->nullable();
            $table->tinyInteger('concierge');
            $table->text('remarks')->nullable();
            $table->text('itinerary')->nullable();
            $table->unsignedBigInteger('transportation_id');
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->unsignedBigInteger('representative_id');
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
        Schema::dropIfExists('daily_sheet_files');
    }
}
