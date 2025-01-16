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
        Schema::table('subscription_charges', function (Blueprint $table) {
            $table->string('quickpay_order_id')->nullable();
            $table->text('payment_details')->nullable();
            $table->text('charge_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_charges', function (Blueprint $table) {
            $table->dropColumn('quickpay_order_id');
            $table->dropColumn('payment_details');
            $table->dropColumn('charge_details');
        });
    }
};
