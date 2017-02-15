<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenditiesTables extends Migration
{
    
    public function up()
    {
        Schema::create('amendities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amendities_name');
            $table->string('amendities_icon');

            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

   
    public function down()
    {
         Schema::drop('amendities');
    }
}
