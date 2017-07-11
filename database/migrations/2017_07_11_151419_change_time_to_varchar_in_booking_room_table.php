<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTimeToVarcharInBookingRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_room', function (Blueprint $table) {
            $table->string('check_in_time', 50)->nullable()->change();
            $table->string('check_out_time', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_room', function (Blueprint $table) {
            //
        });
    }
}
