<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRCategoryAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_category_amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_category_id');
            $table->unsignedInteger('amenity_id');
            $table->string('value');
            $table->string('description');

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
        Schema::drop('r_category_amenities');
    }
}
