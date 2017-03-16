<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('h_room_type_id');
            $table->unsignedInteger('h_room_category_id');
            $table->unsignedInteger('room_view_id');
            $table->text('description');
            $table->string('status');
            $table->text('remark');
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('h_room_type_id')
                ->references('id')->on('h_room_type')
                ->onDelete('restrict');

            $table->foreign('h_room_category_id')
                ->references('id')->on('h_room_category')
                ->onDelete('restrict');

            $table->foreign('room_view_id')
                ->references('id')->on('room_views')
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
        Schema::drop('rooms');
    }
}
