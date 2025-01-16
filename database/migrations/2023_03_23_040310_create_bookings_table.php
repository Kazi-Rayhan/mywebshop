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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('service_id');
            $table->integer('service_type');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->string('payment_id')->nullable();
            $table->string('quick_pay_order_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('payment_status')->default(false);
            $table->foreignId('package_id')->nullable();
            $table->bigInteger('commission')->nullable();
            $table->bigInteger('commission_rate')->nullable();
            $table->string('commission_level')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
