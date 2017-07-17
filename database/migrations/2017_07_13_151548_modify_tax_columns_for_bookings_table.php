<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTaxColumnsForBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['total_tax_amt', 'total_tax_percentage']);
            $table->decimal('total_government_tax_amt')->after('price_w_tax');
            $table->integer('total_government_tax_percentage')->after('total_government_tax_amt');
            $table->decimal('total_service_tax_amt')->after('total_government_tax_percentage');
            $table->integer('total_service_tax_percentage')->after('total_service_tax_amt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
}
