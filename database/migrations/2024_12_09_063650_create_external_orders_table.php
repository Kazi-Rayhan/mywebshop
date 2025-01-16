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
        Schema::create('external_orders', function (Blueprint $table) {
            $table->id();
            $table->ulid();
            $table->foreignId('api_id')->constrained('payment_apis', 'id')->cascadeOnDelete();
            $table->foreignId('payment_method_access_id')->constrained('payment_method_accesses', 'id')->cascadeOnDelete();
            
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_company')->nullable();
            $table->string('customer_country')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_post_code')->nullable();

            $table->json('items')->nullable();



            $table->string('source_url');
            $table->string('success_redirect_url');
            $table->string('failed_redirect_url');

            $table->bigInteger('amount');
            $table->string('currency')->default('NOK');
            $table->string('group')->default('default');
            $table->enum('status', ['PENDING', 'FAILED', 'COMPLETED', 'CANCELED'])->default('PENDING');

            $table->string('payment_method')->default('elavon');
            $table->string('payment_id')->nullable();
            $table->string('payment_url')->nullable();


            $table->text('response')->nullable();
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
        Schema::dropIfExists('external_orders');
    }
};
