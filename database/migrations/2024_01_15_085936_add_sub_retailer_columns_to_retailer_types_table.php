<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retailer_types', function (Blueprint $table) {
            $table->bigInteger('sub_retailer_one_time_pay_out')->nullable();
            $table->bigInteger('sub_retailer_commission_from_recurring_payments')->nullable();
            $table->bigInteger('sub_retailer_commission_from_sales')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retailer_types', function (Blueprint $table) {
            $table->dropColumn('sub_retailer_one_time_pay_out');
            $table->dropColumn('sub_retailer_commission_from_recurring_payments');
            $table->dropColumn('sub_retailer_commission_from_sales');
        });
    }
};
