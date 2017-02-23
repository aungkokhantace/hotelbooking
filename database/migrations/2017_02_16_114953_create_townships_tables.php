<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownshipsTables extends Migration
{

    public function up()
    {
        Schema::create('townships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('city_id');
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('restrict');

        });
    }


    public function down()
    {
        Schema::drop('townships');
    }
}
