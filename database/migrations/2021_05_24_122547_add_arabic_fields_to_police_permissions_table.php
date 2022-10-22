<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicFieldsToPolicePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('police_permissions', function (Blueprint $table) {
            $table->string('travel_agent_ar');
            $table->string('coming_from_ar');
            $table->string('client_name_ar');
            $table->string('nationality_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('police_permissions', function (Blueprint $table) {
            $table->dropColumn('travel_agent_ar');
            $table->dropColumn('coming_from_ar');
            $table->dropColumn('client_name_ar');
            $table->dropColumn('nationality_ar');
        });
    }
}
