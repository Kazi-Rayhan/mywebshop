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
        Schema::table('enterprises', function (Blueprint $table) {
            $table->uuid('unqid')->unique();
            $table->string('enterprise_name')->nullable();
            $table->string('domain')->nullable();
            $table->bigInteger('subscription_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('unqid');
            $table->dropColumn('enterprise_name');
            $table->dropColumn('domain');
            $table->dropColumn('subscription_fee');
        });
    }
};
