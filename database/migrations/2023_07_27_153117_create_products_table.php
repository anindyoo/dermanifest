<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('name_product');
            $table->string('slug');
            $table->integer('price');
            $table->integer('discount_price')->nullable();
            $table->integer('stock');
            $table->text('description');
            $table->text('instruction');
            $table->text('ingredients');
            $table->integer('gross_weight');
            $table->integer('net_weight');
            $table->string('main_picture');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
