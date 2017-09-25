<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFacilityIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_facility', function(Blueprint $table){
            $table->dropForeign('h_facility_facility_id_foreign');
            $table->dropColumn('facility_id');
        });
    }
}
