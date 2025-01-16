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
        Schema::table('external_orders', function (Blueprint $table) {
            $table->string('taxValue')->nullable();
            $table->string('taxTotal')->nullable();
            $table->string('description')->nullable();
            $table->string('orderId')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_orders', function (Blueprint $table) {
            $table->dropColumn('taxValue')->default('elavon');
            $table->dropColumn('taxTotal')->nullable();
            $table->dropColumn('orderId')->nullable();
            $table->dropColumn('description')->nullable();
        });
    }
};
