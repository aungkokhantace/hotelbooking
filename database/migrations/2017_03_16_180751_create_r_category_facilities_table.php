<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRCategoryFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_category_facilities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('facility_id');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('h_room_category_id');
            $table->unsignedInteger('h_room_type_id');
            $table->string('value');
            $table->string('description');
            $table->unsignedInteger('facility_group_id');
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('hotel_id')
//                ->references('id')->on('hotels')
//                ->onDelete('restrict');
//
//            $table->foreign('h_room_type_id')
//                ->references('id')->on('h_room_type')
//                ->onDelete('restrict');
//
//            $table->foreign('h_room_category_id')
//                ->references('id')->on('h_room_category')
//                ->onDelete('restrict');
//
//            $table->foreign('facility_id')
//                ->references('id')->on('facilities')
//                ->onDelete('restrict');
//
//            $table->foreign('facility_group_id')
//                ->references('id')->on('facility_group')
//                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('r_category_facilities');
    }
}
