<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('created_by');
            $table->string('file_no')->unique();
            $table->string('command_no');
            $table->unsignedInteger('travel_agent_id');
            $table->string('client_name');
            $table->string('client_phone')->nullable();
            $table->unsignedInteger('country_id');

            $table->unsignedInteger('adults_count');
            $table->unsignedInteger('children_count');

            $table->unsignedInteger('language_id');

            $table->dateTime('arrival_date');
            $table->dateTime('departure_date');

            $table->unsignedInteger('airport_from_id');
            $table->unsignedInteger('airport_to_id');

            $table->dateTime('request_date');

            $table->text('profiling')->nullable();
            $table->text('remarks')->nullable();

            $table->tinyInteger('notify_police')->default(0);
            $table->tinyInteger('service_conciergerie')->default(0);
            $table->tinyInteger('router')->default(0);
            $table->tinyInteger('proforma')->default(0);
            $table->tinyInteger('gifts')->default(0);

            $table->tinyInteger('status');//0 not approved, 1 approved, 2 declined
            $table->unsignedInteger('employee_id_1_reviewed')->nullable();//first user will review
            $table->tinyInteger('employee_1_review_result')->nullable();//first emp review status
            $table->unsignedInteger('employee_id_2_reviewed')->nullable();//second user will review
            $table->tinyInteger('employee_2_review_result')->nullable();//second emp review status

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
        Schema::dropIfExists('job_files');
    }
}
