<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('room_id');
            $table->decimal('base_rate', 8, 2);
            $table->unsignedTinyInteger('base_rate_currency');
            $table->timestamp('price_valid_from')->nullable();
            $table->timestamp('price_valid_to')->nullable();
            $table->decimal('extra_bed_exc', 8, 2)->nullable();
            $table->integer('child_free_until')->default(99);
            $table->decimal('child_with_two_parents_exc', 8, 2)->nullable();
            $table->integer('max_children_with_two_parents')->nullable();
            $table->decimal('single_parent_exc', 8, 2)->nullable();
            $table->decimal('single_parent_child_exc', 8, 2)->nullable();
            $table->integer('min_child_age')->default(0);
            $table->integer('max_child_age')->default(99);
            $table->text('special_offer')->nullable();
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
        Schema::dropIfExists('room_details');
    }
}
