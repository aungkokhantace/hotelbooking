<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('payment_amount_wo_tax');
            $table->decimal('payment_amount_w_tax');
            $table->text('description');
            $table->integer('booking_id');
            $table->integer('payment_id');
            $table->decimal('payment_gateway_tax_amt');
            $table->integer('status');
            $table->integer('payment_tax_percentage');
            $table->decimal('payment_tax_amt');
            $table->decimal('total_payable_amt');
            $table->string('payment_reference_no')->nullable();
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booking_payment');
    }
}
