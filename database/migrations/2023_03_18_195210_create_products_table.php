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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('item')->nullable();
            $table->string('name')->nullable();
            $table->string('ean')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->text('areas')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('saleprice')->nullable();
            $table->unsignedBigInteger('retailerprice')->nullable();
            $table->unsignedBigInteger('retailersaleprice')->nullable();
            $table->text('details')->nullable();
            $table->string('sku')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->unsignedInteger('view')->default(0);
            $table->unsignedInteger('sale_count')->default(1);
            $table->boolean('status')->nullable()->default(false);
            $table->unsignedInteger('tax')->nullable();
            $table->boolean('is_variable')->nullable()->default(false);
            $table->string('variation')->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->boolean('featured')->nullable()->default(false);
            $table->unsignedInteger('discount')->nullable();
            $table->string('qrcode')->nullable();
            $table->unsignedInteger('order_no')->nullable();
            $table->boolean('pin')->default(false);
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
        Schema::dropIfExists('products');
    }
};
