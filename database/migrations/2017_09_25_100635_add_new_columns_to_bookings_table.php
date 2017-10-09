<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_cancel_income')->after('total_discount_percentage');
            $table->decimal('total_stripe_fee_percent')->after('total_cancel_income');
            $table->decimal('stripe_fee_default_cent')->after('total_stripe_fee_percent');
            $table->decimal('total_stripe_fee_amt')->after('total_cancel_income');
            $table->decimal('total_stripe_net_amt')->after('total_stripe_fee_amt');
            $table->decimal('total_vendor_net_amt')->after('total_stripe_net_amt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('total_cancel_income');
            $table->dropColumn('total_stripe_fee_amt');
            $table->dropColumn('total_stripe_net_amt');
            $table->dropColumn('total_vendor_net_amt');

        });
    }
}
