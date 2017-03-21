<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_discount', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('h_room_type_id');
            $table->unsignedInteger('h_room_category_id');
            $table->string('type',45);
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('discount_percent');
            $table->decimal('discount_amount');
            $table->text('remark');
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

            $table->foreign('h_room_category_id')
                ->references('id')->on('h_room_category')
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
        Schema::drop('room_discount');
    }
}
