<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMonthlyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_monthly_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('request_date');
            $table->integer('files_count');
            $table->decimal('amount', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('words');
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
        Schema::dropIfExists('payment_monthly_requests');
    }
}
