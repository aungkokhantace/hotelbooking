<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUniqueConstraintFromCoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('core_users', function (Blueprint $table) {
          // $table->dropUnique('core_users_user_name_unique');
          $table->dropUnique(['email']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('core_users', function (Blueprint $table) {
          //
      });
    }
}
