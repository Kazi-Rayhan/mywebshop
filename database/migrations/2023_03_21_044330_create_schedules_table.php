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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('scheduleable_id');
            $table->foreignId('parent_id')->nullable();
            $table->string('scheduleable_type');
            $table->string('day')->nullable();
            $table->date('schedule_at')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->boolean('is_open')->default(false);
            $table->boolean('is_break')->default(false);
            $table->unique(['scheduleable_id', 'scheduleable_type', 'schedule_at']);
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
        Schema::dropIfExists('schedules');
    }
};
