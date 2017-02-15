<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomCategoryAmenditiesTables extends Migration
{
    
    public function up()
    {
        Schema::create('room_category_amendities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('amendities_id');
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('amendities_id')
                ->references('id')->on('amendities')
                ->onDelete('restrict');
            
        });
    }

    
    public function down()
    {
        Schema::drop('room_category_amendities');
    }
}
