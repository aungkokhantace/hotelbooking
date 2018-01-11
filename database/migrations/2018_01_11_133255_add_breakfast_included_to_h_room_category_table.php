<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBreakfastIncludedToHRoomCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_room_category', function (Blueprint $table) {
            $table->boolean('breakfast_included')->after('extra_bed_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_room_category', function (Blueprint $table) {
            $table->dropColumn('breakfast_included');
        });
    }
}
