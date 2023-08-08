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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('address_id')->constrained();
            $table->string('recipient');
            $table->string('phone');            
            $table->string('delivery_courier');
            $table->string('delivery_service');
            $table->integer('delivery_cost');
            $table->integer('subtotal');
            $table->integer('grand_total');
            $table->integer('quantity_total');
            $table->integer('gross_weight_total');
            $table->string('status');
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
