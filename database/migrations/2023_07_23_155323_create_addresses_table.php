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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('province_api_id');
            $table->integer('city_api_id');
            $table->string('name_address');
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('address');
            $table->string('province');
            $table->string('city');
            $table->string('postal_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
