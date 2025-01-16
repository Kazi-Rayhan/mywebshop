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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trainer_id')->constrained('users', 'id')->cascadeOnDelete();

            $table->boolean('status')->default(true);
            $table->string('type')->default('session_credits');

            $table->unsignedBigInteger('manager_credits')->nullable()->default(0);
            $table->unsignedBigInteger('admin_credits')->nullable()->default(0);
            $table->unsignedBigInteger('subscription_credits')->nullable()->default(0);
            $table->unsignedBigInteger('session_credits')->nullable()->default(0);

            $table->timestamp('subscription_credits_expire_at')->nullable();
            $table->timestamp('session_credits_expire_at')->nullable();

            $table->unsignedBigInteger('history')->nullable()->default(0);
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
        Schema::dropIfExists('credits');
    }
};
