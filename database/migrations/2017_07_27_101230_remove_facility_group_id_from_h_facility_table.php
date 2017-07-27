<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFacilityGroupIdFromHFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_facility', function (Blueprint $table) {
            $table->dropForeign(['facility_group_id']);
            $table->dropColumn('facility_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_facility', function (Blueprint $table) {
            //
        });
    }
}
