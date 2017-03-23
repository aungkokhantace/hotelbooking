<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRBlackoutPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_blackout_period', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('room_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->text('remark');
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hotel_id')
                ->references('id')->on('hotels')
                ->onDelete('restrict');

            $table->foreign('room_id')
                ->references('id')->on('rooms')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('r_blackout_period');
    }
}
