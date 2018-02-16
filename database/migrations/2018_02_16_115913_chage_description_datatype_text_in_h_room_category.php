<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChageDescriptionDatatypeTextInHRoomCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_room_category', function (Blueprint $table) {
           $table->text('description')->change();
           $table->text('remark')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_room_category', function (Blueprint $table) {
            //
        });
    }
}
