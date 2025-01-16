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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('url')
                ->nullable();
            $table->string('key')
                ->nullable()
                ->unique();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('subscribable_id')->nullable();
            $table->string('subscribable_type')->nullable();
            $table->boolean('establishment_status')
                ->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('fee')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
};
