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
        Schema::create('enterprise_onboardings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('key')->nullable();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_address');
            $table->string('company_registration');
            $table->string('company_domain');
            $table->tinyInteger('status')->default(0);
            $table->integer('fee')->default(0);
            $table->boolean('is_establishment')->default(false);
            $table->integer('establishment_fee')->default(0);
            $table->date('last_paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_onboardings');
    }
};
