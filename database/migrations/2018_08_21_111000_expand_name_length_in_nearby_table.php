<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpandNameLengthInNearbyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nearby', function (Blueprint $table) {
          // $table->string('name_jp',255)->after('name');
          $table->string('name',255)->change();
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
