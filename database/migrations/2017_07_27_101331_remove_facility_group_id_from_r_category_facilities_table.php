<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFacilityGroupIdFromRCategoryFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('r_category_facilities', function (Blueprint $table) {
//            $table->dropForeign(['facility_group_id']);
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
        Schema::table('r_category_facilities', function (Blueprint $table) {
            //
        });
    }
}
