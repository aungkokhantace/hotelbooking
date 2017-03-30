<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('opening_hours');
            $table->string('opening_days');
            $table->string('capacity');
            $table->string('area');
            $table->string('floor');
            $table->boolean('private_room');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('h_restaurant_category_id');
            $table->text('description');
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

            $table->foreign('h_restaurant_category_id')
                ->references('id')->on('h_restaurant_categories')
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
        Schema::drop('h_restaurant');
    }
}
