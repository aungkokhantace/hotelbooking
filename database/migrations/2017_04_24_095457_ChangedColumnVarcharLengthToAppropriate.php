<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangedColumnVarcharLengthToAppropriate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('phone', 50)->nullable()->change();
            $table->string('fax', 30)->nullable()->change();
            $table->string('latitude', 20)->nullable()->change();
            $table->string('longitude', 20)->nullable()->change();
            $table->string('email', 50)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
            $table->integer('class')->change();
            $table->string('website', 50)->nullable()->change();
            $table->time('check_in_time')->nullable()->change();
            $table->time('check_out_time')->nullable()->change();
            $table->time('breakfast_start_time')->nullable()->change();
            $table->time('breakfast_end_time')->nullable()->change();
        });

        Schema::table('cities', function (Blueprint $table) {
        $table->string('name', 50)->nullable()->change();
    });

        Schema::table('h_room_type', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
        });

        Schema::table('h_restaurant', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->time('opening_hours')->nullable()->change();
            $table->time('closing_hours',100)->after('opening_hours')->nullable();
            $table->string('opening_days', 50)->nullable()->change();
            $table->integer('capacity')->nullable()->change();
            $table->string('area', 30)->nullable()->change();
            $table->integer('floor')->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('h_restaurant_categories', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
        });

        Schema::table('amenities', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
        });

        Schema::table('landmarks', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
        });

        Schema::table('h_nearby_station', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('h_nearby_hospital', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('h_nearby_drug_store', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('h_nearby_convenience_store', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('h_nearby_airport', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->string('description', 255)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('h_room_category', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('r_blackout_period', function (Blueprint $table) {
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('room_discount', function (Blueprint $table) {
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('r_available_period', function (Blueprint $table) {
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('facilities', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->change();
            $table->string('remark', 255)->nullable()->change();
        });

        Schema::table('core_users', function (Blueprint $table) {
            $table->string('user_name', 50)->nullable()->change();
            $table->string('first_name',50)->after('user_name')->nullable();
            $table->string('last_name',50)->after('first_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
