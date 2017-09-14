<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivationCodeAndConfirmToCoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_users', function (Blueprint $table) {
            $table->string('activation_code',50)->after('status');
            $table->boolean('confirm')->default(0)->after('activation_code');
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
            $table->dropColumn('activation_code');
            $table->dropColumn('confirm');
        });
    }
}
