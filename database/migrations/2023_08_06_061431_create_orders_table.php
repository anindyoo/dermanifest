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
            $table->integer('customer_id');
            $table->integer('address_id');
            $table->string('recipient');
            $table->string('email');
            $table->string('phone');            
            $table->string('delivery_courier');
            $table->string('delivery_service');
            $table->integer('delivery_cost');
            $table->integer('subtotal');
            $table->integer('grand_total');
            $table->integer('quantity_total');
            $table->integer('gross_weight_total');
            $table->enum('status', ['unpaid', 'paid', 'delivering', 'completed']);
            $table->text('note')->nullable();
            $table->string('snap_token')->default('0');   
            $table->string('delivery_code')->nullable();
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
