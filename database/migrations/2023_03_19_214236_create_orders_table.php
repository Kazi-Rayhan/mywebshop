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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('referral_code')->nullable();
            $table->string('payment_id')->nullable();
            $table->text('payment_url')->nullable();

            $table->decimal('discount', 8, 2)->nullable();
            $table->string('discount_code')->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('shipping_cost', 8, 2)->nullable();
            $table->string('shipping_method')->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('refund')->default(null)->nullable();
            $table->integer('payment_status')->default(null)->nullable();
            $table->integer('is_company')->default(false)->nullable();
            $table->string('currency')->default('NOK');
            $table->tinyInteger('type')->nullable()->default(0);
            
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
        Schema::dropIfExists('orders');
    }
};
