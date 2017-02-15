<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTables extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city_name');
            $table->unsignedInteger('township_id');
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('township_id')
                ->references('id')->on('townships')
                ->onDelete('restrict');
            
        });
    }


    public function down()
    {
        Schema::drop('cities');
    }
}
