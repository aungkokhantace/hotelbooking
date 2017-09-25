<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnInHFeatureToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_feature', function(Blueprint $table) {
            $table->integer('qty')->nullable()->change();
            $table->integer('capacity')->nullable()->change();
            $table->text('area')->nullable()->change();
            $table->text('open_hour')->nullable()->change();
            $table->text('close_hour')->nullable()->change();
            $table->text('remark')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrations', function(Blueprint $table) {
            $table->integer('qty')->change();
            $table->integer('capacity')->change();
            $table->text('area')->change();
            $table->text('open_hour')->change();
            $table->text('close_hour')->change();
            $table->text('remark')->change();
        });

    }
}
