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
        Schema::table('credits', function (Blueprint $table) {
            $table->tinyInteger('split')->default(false);
            $table->integer('remaining_split')->default(0);
            $table->integer('split_duration')->default(0);
            $table->integer('split_price')->default(0);
            $table->timestamp('next_payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('split');
            $table->dropColumn('total_split');
            $table->dropColumn('remaining_split');
            $table->dropColumn('split_duration');
            $table->dropColumn('split_price');
            $table->dropColumn('next_payment_date');
        });
    }
};
