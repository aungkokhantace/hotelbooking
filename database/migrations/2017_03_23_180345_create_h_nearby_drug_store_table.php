<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHNearbyDrugStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_nearby_drug_store', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('distance');
            $table->text('remark');
            $table->unsignedInteger('hotel_id');
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hotel_id')
                ->references('id')->on('hotels')
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
        Schema::drop('h_nearby_drug_store');
    }
}
