<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('salary')->nullable();
            $table->decimal('commission', 8,2)->default(0);
            $table->tinyInteger('gender'); //0 male, 1 female
            $table->tinyInteger('outsource');
            $table->unsignedInteger('supervisor_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->date('hired_at')->nullable();
            $table->date('promoted_at')->nullable();
            $table->unsignedInteger('points')->nullable();
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('department_id')->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('employees');
    }
}
