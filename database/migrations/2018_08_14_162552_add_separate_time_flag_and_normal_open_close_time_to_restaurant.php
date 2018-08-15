<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeparateTimeFlagAndNormalOpenCloseTimeToRestaurant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_restaurant', function (Blueprint $table) {
          $table->tinyInteger('has_separate_open_close_hours')->after('name')->default(0);
          $table->string('normal_opening_hours')->after('dinner_closing_hours')->nullable();
          $table->string('normal_closing_hours')->after('normal_opening_hours')->nullable();
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
          $table->dropColumn('has_separate_open_close_hours');
          $table->dropColumn('normal_opening_hours');
          $table->dropColumn('normal_closing_hours');
        });
    }
}
