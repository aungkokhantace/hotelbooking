<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDatatypeOfAllPercentageToBookingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payment', function (Blueprint $table) {
            $table->decimal('total_government_tax_percentage')->change();
            $table->decimal('total_service_tax_percentage')->change();
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
