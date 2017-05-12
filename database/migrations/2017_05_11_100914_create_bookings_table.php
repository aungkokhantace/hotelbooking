<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('booking_no');
            $table->integer('user_id');
            $table->integer('status');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->boolean('for_other');
            $table->decimal('price_wo_tax')->nullable();
            $table->decimal('price_w_tax')->nullable();
            $table->decimal('total_tax_amt')->nullable();
            $table->integer('total_tax_percentage')->nullable();
            $table->decimal('total_payable_amt')->nullable();
            $table->integer('room_discount_id');
            $table->decimal('total_discount_amt')->nullable();
            $table->integer('total_discount_percentage');
            $table->integer('guest_count');
            $table->integer('hotel_id');
            $table->integer('h_room_type_id');
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
        Schema::drop('bookings');
    }
}
