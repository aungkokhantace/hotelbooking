<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_image', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_url', 45);
            $table->string('defatult_image')->nullable();
            $table->string('title', 45);
            $table->string('description', 255);
            $table->integer('template_id');
            $table->integer('status')->default(1);
            //-------common to all tables--------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('site_image');
    }
}
