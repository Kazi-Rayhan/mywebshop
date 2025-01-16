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
        Schema::create('payment_method_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_address');
            $table->string('company_registration');
            $table->string('company_domain')->unique();
            $table->boolean('status')->default(false);
            $table->boolean('contract_signed')->default(false);
            $table->boolean('contract_status')->default(false);
            $table->boolean('kyc_status')->default(false);
            $table->string('contract_url')->default(false);
            $table->string('key')->unique()->nullable();
            $table->string('quickpay_api_key')->unique()->nullable();
            $table->string('quickpay_secret_key')->unique()->nullable();
            $table->timestamp('last_paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method_accesses');
    }
};
