<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTaxColumnsForBookingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payment', function (Blueprint $table) {
            $table->dropColumn(['payment_tax_percentage', 'payment_tax_amt']);
            $table->decimal('total_government_tax_amt')->after('status');
            $table->integer('total_government_tax_percentage')->after('total_government_tax_amt');
            $table->decimal('total_service_tax_amt')->after('total_government_tax_percentage');
            $table->integer('total_service_tax_percentage')->after('total_service_tax_amt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_payment', function (Blueprint $table) {
            //
        });
    }
}
