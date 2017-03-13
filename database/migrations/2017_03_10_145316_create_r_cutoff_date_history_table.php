<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRCutoffDateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_cutoff_date_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('h_room_category_id');
            $table->text('remark');
            $table->integer('cutoff_date_count');
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hotel_id')
                ->references('id')->on('hotels')
                ->onDelete('restrict');

            $table->foreign('h_room_category_id')
                ->references('id')->on('h_room_category')
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
        Schema::drop('r_cutoff_date_history');
    }
}
