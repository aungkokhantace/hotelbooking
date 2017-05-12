<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id');
            $table->boolean('non_smoking_room');
            $table->boolean('late_check_in');
            $table->boolean('early_check_in');
            $table->boolean('high_floor_room');
            $table->boolean('large_bed');
            $table->boolean('twin_bed');
            $table->boolean('quiet_room');
            $table->boolean('baby_cot');
            $table->boolean('airport_transfer');
            $table->boolean('private_parking');
            $table->string('special_request')->nullable();
            $table->boolean('booking_taxi');
            $table->boolean('booking_tour_guide');
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
        Schema::drop('booking_request');
    }
}
