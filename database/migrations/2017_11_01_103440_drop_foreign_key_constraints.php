<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function(Blueprint $table){
            $table->dropForeign(['country_id']);
        });

        Schema::table('townships', function(Blueprint $table){
            $table->dropForeign(['city_id']);
        });

        Schema::table('h_room_type', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
        });

        Schema::table('h_room_category', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['h_room_type_id']);
        });

        Schema::table('r_cutoff_date_history', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['h_room_category_id']);
        });

        Schema::table('r_category_image', function(Blueprint $table){
            $table->dropForeign(['h_room_category_id']);
        });

        Schema::table('rooms', function(Blueprint $table){
            $table->dropForeign(['h_room_type_id']);
            $table->dropForeign(['h_room_category_id']);
            $table->dropForeign(['room_view_id']);
        });

        Schema::table('h_feature', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['feature_id']);
        });

        Schema::table('room_discount', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['h_room_type_id']);
            $table->dropForeign(['h_room_category_id']);
        });

        Schema::table('r_blackout_period', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['room_id']);
        });

        Schema::table('r_available_period', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['room_id']);
        });

        Schema::table('h_restaurant', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['h_restaurant_category_id']);
        });

        Schema::table('h_facility', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
        });

        Schema::table('landmarks', function(Blueprint $table){
            $table->dropForeign(['township_id']);
        });

        Schema::table('h_landmark', function(Blueprint $table){
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['landmark_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
