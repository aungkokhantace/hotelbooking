<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameJpAndExpandNameLengthInHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
          $table->string('name',255)->change();
          $table->string('name_jp',255)->after('name');
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
