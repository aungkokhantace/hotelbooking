<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRemarkDataTypeToTextInrAvalilablePeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('r_available_period', function (Blueprint $table) {
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
        Schema::table('r_available_period', function (Blueprint $table) {
            //
        });
    }
}
