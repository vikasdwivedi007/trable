<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_assignments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('daily_sheet_id')->nullable();
            $table->tinyInteger('status');
            $table->string('router_number')->nullable();
            $table->text('remarks')->nullable();
            $table->text('itinerary')->nullable();
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
        Schema::dropIfExists('operator_assignments');
    }
}
