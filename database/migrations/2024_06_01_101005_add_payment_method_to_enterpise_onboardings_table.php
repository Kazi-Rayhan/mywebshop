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
        Schema::table('enterprise_onboardings', function (Blueprint $table) {
            $table->string('paymentMethod')->default('quickpay');
            $table->string('api')->nullable();
            $table->string('contract_url')->nullable();
            $table->tinyInteger('contract_signed')->default(0);
            $table->tinyInteger('contract_status')->default(0);
            $table->tinyInteger('kyc_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprise_onboardings', function (Blueprint $table) {
            $table->dropColumn('paymentMethod');
            $table->dropColumn('api');
            $table->dropColumn('contract_url');
            $table->dropColumn('contract_signed');
            $table->dropColumn('contract_status');
            $table->dropColumn('kyc_status');
        });
    }
};
