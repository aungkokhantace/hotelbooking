<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_room', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id');
            $table->integer('user_id');
            $table->integer('room_id');
            $table->integer('hotel_id');
            $table->integer('status');
            $table->date('check_in_date');
            $table->time('check_in_time');
            $table->date('check_out_date');
            $table->time('check_out_time');
            $table->text('remark');
            $table->decimal('room_price',8,2);
            $table->boolean('added_extra_bed');
            $table->decimal('extra_bed_price',8,2);
            $table->string('user_first_name',45);
            $table->string('user_last_name',45);
            $table->string('user_email',100);
            $table->integer('guest_count');
            $table->boolean('smoking');
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
        Schema::drop('booking_room');
    }
}
