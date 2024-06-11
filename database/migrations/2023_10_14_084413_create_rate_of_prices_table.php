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
        Schema::create('rate_of_prices', function (Blueprint $table) {
            $table->id();
             $table->string('placeName');
            // $table->date('expiryDate')->nullable();
            // $table->unsignedBigInteger('merchant_id')->nullable();
            // $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->string('ratePlace');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_of_prices');
    }
};
