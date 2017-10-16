<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToBookingRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_room', function (Blueprint $table) {
            $table->decimal('discount_amt_af')->after('refund_amt');
            $table->decimal('extra_bed_price_af')->after('discount_amt_af');
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
            $table->dropColumn('discount_amt_af');
            $table->dropColumn('extra_bed_price_af');
        });
    }
}
