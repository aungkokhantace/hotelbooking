<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToHRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_restaurant', function (Blueprint $table) {
          $table->string('lunch_opening_hours')->after('breakfast_closing_hours')->nullable();
          $table->string('lunch_closing_hours')->after('lunch_opening_hours')->nullable();
          $table->string('dinner_opening_hours')->after('lunch_closing_hours')->nullable();
          $table->string('dinner_closing_hours')->after('dinner_opening_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_restaurant', function (Blueprint $table) {
          $table->dropColumn('lunch_opening_hours');
          $table->dropColumn('lunch_closing_hours');
          $table->dropColumn('dinner_opening_hours');
          $table->dropColumn('dinner_closing_hours');
        });
    }
}
