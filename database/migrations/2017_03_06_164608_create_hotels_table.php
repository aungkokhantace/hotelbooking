<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->integer('latitude')->nullable();
            $table->integer('longitude')->nullable();
            $table->string('logo')->nullable();
            $table->string('star');
            $table->string('email');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->integer('township_id');
            $table->text('description')->nullable();
            $table->integer('number_of_floors');
            $table->string('class');
            $table->string('website')->nullable();
            $table->string('check_in_time');
            $table->string('check_out_time');
            $table->string('breakfast_start_time');
            $table->string('breakfast_end_time');

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
        Schema::drop('hotels');
    }
}
