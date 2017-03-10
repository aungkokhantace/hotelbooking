<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHRoomCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_room_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('hotel_id');
            $table->double('square_metre');
            $table->integer('capacity');
            $table->integer('booking_cutoff_day');
            $table->boolean('extra_bed_allowed');
            $table->decimal('extra_bed_price');
            $table->unsignedInteger('h_room_type_id');
            $table->string('bed_type');
            $table->text('description')->nullable();
            $table->decimal('price');

            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hotel_id')
                ->references('id')->on('hotels')
                ->onDelete('restrict');

            $table->foreign('h_room_type_id')
                ->references('id')->on('h_room_type')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('h_room_category');
    }
}
