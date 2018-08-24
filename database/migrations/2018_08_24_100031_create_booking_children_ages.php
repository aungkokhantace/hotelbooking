<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingChildrenAges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('booking_children_ages', function (Blueprint $table) {
        $table->integer('booking_id');
        $table->integer('child_age');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('hotels', function (Blueprint $table) {
          //
      });
    }
}
