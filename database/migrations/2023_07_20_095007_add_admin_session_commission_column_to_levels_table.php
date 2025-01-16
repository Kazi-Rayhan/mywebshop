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
        Schema::table('levels', function (Blueprint $table) {
            $table->bigInteger('expire_session_commission')->default(0)->after('commission');
            $table->bigInteger('admin_session_commission')->default(0)->after('expire_session_commission');
            $table->bigInteger('manager_session_commission')->default(0)->after('admin_session_commission');
            $table->bigInteger('demo_session_commission')->default(0)->after('manager_session_commission');
            $table->text('bonus')->nullable()->after('demo_session_commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('expire_session_commission');
            $table->dropColumn('admin_session_commission');
            $table->dropColumn('manager_session_commission');
            $table->dropColumn('demo_session_commission');
            $table->dropColumn('bonus');
        });
    }
};
