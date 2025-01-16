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
        Schema::create('language_shop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->nullable();
            $table->foreignId('language_id')->nullable();
            $table->text('english')->nullable();
            $table->text('spanish')->nullable();
            $table->text('norwegian')->nullable();
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
        Schema::dropIfExists('language_shop');
    }
};
