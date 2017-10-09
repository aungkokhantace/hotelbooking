<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToBookingRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_room', function (Blueprint $table) {
            $table->dropColumn('room_payable_amt');
            $table->decimal('room_payable_amt_wo_tax')->after('discount_amt');
            $table->decimal('government_tax_amt')->after('room_payable_amt_wo_tax');
            $table->decimal('service_tax_amt')->after('government_tax_amt');
            $table->decimal('room_payable_amt_w_tax')->after('service_tax_amt');
            $table->decimal('stripe_fee_percent')->after('room_payable_amt_w_tax');
            $table->decimal('room_net_amt')->after('stripe_fee_percent');
            $table->decimal('refund_amt')->after('room_net_amt');
            $table->decimal('room_payable_amt_wo_tax_af')->after('refund_amt');
            $table->decimal('government_tax_amt_af')->after('room_payable_amt_wo_tax_af');
            $table->decimal('service_tax_amt_af')->after('government_tax_amt_af');
            $table->decimal('room_payable_amt_w_tax_af')->after('service_tax_amt_af');
            $table->decimal('stripe_fee_percent_af')->after('room_payable_amt_w_tax_af');
            $table->decimal('room_net_amt_af')->after('stripe_fee_percent_af');
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
            $table->dropColumn('room_payable_amt_wo_tax');
            $table->dropColumn('government_tax_amt');
            $table->dropColumn('service_tax_amt');
            $table->dropColumn('room_payable_amt_w_tax');
            $table->dropColumn('stripe_fee_amt');
            $table->dropColumn('room_net_amt');
            $table->dropColumn('refund_amt');
            $table->dropColumn('room_payable_amt_wo_tax_af');
            $table->dropColumn('government_tax_amt_af');
            $table->dropColumn('service_tax_amt_af');
            $table->dropColumn('room_payable_amt_w_tax_af');
            $table->dropColumn('stripe_fee_amt_af');
            $table->dropColumn('room_net_amt_af');

        });
    }
}
