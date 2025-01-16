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
        Schema::create('payment_apis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_access_id')->constrained('payment_method_accesses', 'id')->cascadeOnDelete();
            $table->string('key');
            $table->string('domain');
            $table->string('success_redirect_url');
            $table->string('failed_redirect_url');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('payment_apis');
    }
};
