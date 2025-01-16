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
        Schema::table('shops', function (Blueprint $table) {
            $table->foreignId('previous_retailer')
                ->nullable()
                ->constrained('users', 'id');
            $table->date('retailer_joined_at')->nullable();
            $table->date('previous_retailer_suspended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('previous_retailer');
            $table->dropColumn('retailer_joined_at');
            $table->dropColumn('previous_retailer_suspended_at');
        });
    }
};