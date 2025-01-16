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
        Schema::create('credit_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('shop_id')->nullable();
            $table->foreignId('manager_id')->nullable();
            
            $table->string('type')->default('session_credits');
            
            $table->foreignId('package_id')->nullable();
            $table->bigInteger('price')->nullable()->default(0);
            
            $table->bigInteger('credits')->nullable()->default(0);
            $table->bigInteger('history')->nullable()->default(0);
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
        Schema::dropIfExists('credit_histories');
    }
};
