<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveReviewAndStatusColumnsFromJobFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_files', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('employee_id_1_reviewed');
            $table->dropColumn('employee_1_review_result');
            $table->dropColumn('employee_id_2_reviewed');
            $table->dropColumn('employee_2_review_result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_files', function (Blueprint $table) {
            $table->tinyInteger('status');//0 not approved, 1 approved, 2 declined
            $table->unsignedInteger('employee_id_1_reviewed')->nullable();//first user will review
            $table->tinyInteger('employee_1_review_result')->nullable();//first emp review status
            $table->unsignedInteger('employee_id_2_reviewed')->nullable();//second user will review
            $table->tinyInteger('employee_2_review_result')->nullable();//second emp review status
        });
    }
}
