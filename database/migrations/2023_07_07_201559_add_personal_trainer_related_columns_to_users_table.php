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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('pt_package_id')->nullable();
            $table->foreignId('pt_trainer_id')->nullable();
            $table->bigInteger('pt_package_price')->nullable();
            $table->text('pt_package_purchase_history')->nullable();
            $table->boolean('pt_free_tier')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pt_package_id');
            $table->dropColumn('pt_trainer_id');
            $table->dropColumn('pt_package_price');
            $table->dropColumn('pt_package_purchase_history');
            $table->dropColumn('pt_free_tier');
        });
    }
};
