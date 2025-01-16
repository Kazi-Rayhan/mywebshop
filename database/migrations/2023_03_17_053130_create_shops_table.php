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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('retailer_id')->nullable();
            $table->string('user_name')->unique();
            $table->text('terms')->nullable();
            $table->string('payment_order_id')->nullable();
            $table->unsignedInteger('tax')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->text('payment_url')->nullable();
            $table->boolean('establishment')->nullable()->default(false);
            $table->unsignedInteger('establishment_cost')->nullable();
            $table->unsignedInteger('monthly_cost')->nullable();
            $table->boolean('service_establishment')->nullable()->default(false);
            $table->unsignedInteger('service_establishment_cost')->nullable()->default(0);
            $table->unsignedInteger('service_monthly_fee')->nullable()->default(0);
            $table->boolean('can_provide_service')->nullable()->default(false);
            $table->unsignedInteger('per_user_fee')->nullable();
            $table->string('locations')->nullable();
            $table->unsignedInteger('selling_location_mode')->nullable();
            $table->boolean('contract_signed')->nullable()->default(false);
            $table->boolean('contract_status')->nullable()->default(false);
            $table->string('default_currency')->nullable()->default('NOK');
            $table->text('currencies')->nullable();
            $table->text('country')->nullable();
            $table->text('default_language')->nullable();
            $table->text('contract_url')->nullable();
            $table->unsignedInteger('area_id')->nullable();
            $table->boolean('store_as_pickup_point')->nullable()->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->string('area')->nullable();
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
        Schema::dropIfExists('shops');
    }
};
