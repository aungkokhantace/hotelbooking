<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameJpToNearByTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nearby', function (Blueprint $table) {
          $table->string('name_jp',50)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nearby', function (Blueprint $table) {
            $table->dropColumn('name_jp');
        });
    }
}
