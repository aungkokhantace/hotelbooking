<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyHRestaurantTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_restaurant', function (Blueprint $table) {
            $table->renameColumn('opening_hours','breakfast_opening_hours');
            $table->renameColumn('closing_hours','breakfast_closing_hours');
            $table->string('floor', 50)->change()->nullable();
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
            $table->renameColumn('breakfast_opening_hours', 'opening_hours');
            $table->renameColumn('breakfast_closing_hours', 'closing_hours');
        });
    }
}
