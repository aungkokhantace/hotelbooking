<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleJpAndDescriptionJpToSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_image', function (Blueprint $table) {
            $table->string('title_jp')->after('title')->nullable();
            $table->string('description_jp')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_image', function (Blueprint $table) {
            $table->dropColumn('title_jp');
            $table->dropColumn('description_jp');
        });
    }
}
