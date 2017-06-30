<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('h_nearby_station');
        Schema::drop('h_nearby_hospital');
        Schema::drop('h_nearby_convenience_store');
        Schema::drop('h_nearby_drug_store');
        Schema::drop('h_nearby_airport');
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
