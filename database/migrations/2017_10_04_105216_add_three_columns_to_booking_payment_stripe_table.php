<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeColumnsToBookingPaymentStripeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payment_stripe', function (Blueprint $table) {
            $table->string('stripe_balance_transaction')->after('stripe_payment_id');
            $table->decimal('stripe_payment_net')->after('stripe_balance_transaction');
            $table->decimal('stripe_payment_fee')->after('stripe_payment_net');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_payment_stripe', function (Blueprint $table) {
            $table->dropColumn('stripe_balance_transaction');
            $table->dropColumn('stripe_payment_net');
            $table->dropColumn('stripe_payment_fee');
        });
    }
}
