<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_forms', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('emp_id');
            $table->decimal('additional_fees', 10, 2);
            $table->text('additional_desc');
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
        Schema::dropIfExists('cash_forms');
    }
}
