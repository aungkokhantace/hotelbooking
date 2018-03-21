<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUniqueConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('countries', function (Blueprint $table) {
          $table->dropUnique('countries_name_unique');
      });

      Schema::table('cities', function (Blueprint $table) {
          $table->dropUnique('cities_name_unique');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('countries', function (Blueprint $table) {
          //
      });
      Schema::table('cities', function (Blueprint $table) {
          //
      });
    }
}
