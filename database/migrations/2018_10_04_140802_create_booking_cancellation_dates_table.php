<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingCancellationDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_cancellation_dates', function (Blueprint $table) {
          $table->integer('booking_id');
          $table->integer('first_cancellation_day_count')->default(0);
          $table->integer('second_cancellation_day_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booking_cancellation_dates');
    }
}
