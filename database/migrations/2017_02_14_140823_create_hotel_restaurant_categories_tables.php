<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelRestaurantCategoriesTables extends Migration
{
   
    public function up()
    {
       Schema::create('hotel_restaurant_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotel_restaurant_category_name');
           
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

   
    public function down()
    {
        Schema::drop('hotel_restaurant_categories');
    }
}
