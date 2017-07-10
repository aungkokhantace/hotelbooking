<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNamesForHConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_config', function (Blueprint $table) {
            $table->renameColumn('first_cancellation_day', 'first_cancellation_day_count');
            $table->renameColumn('second_cancellation_day', 'second_cancellation_day_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_config', function (Blueprint $table) {
            //
        });
    }
}
