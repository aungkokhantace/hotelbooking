<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTwoCancellationDatesInHConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_config', function (Blueprint $table) {
            $table->dropColumn('cancellation_days');
            $table->Integer('first_cancellation_day')->after('hotel_id');
            $table->Integer('second_cancellation_day')->after('first_cancellation_day');
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

        });
    }
}
