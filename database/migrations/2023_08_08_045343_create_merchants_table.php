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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_name');
            $table->string('merchant_email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('merchant_number');
            $table->string('merchant_secondary_number')->nullable();
            // $table->string('merchant_confirm')->nullable();
            $table->string('merchant_password');
            $table->string('company_name');
            $table->text('merchant_image')->nullable();
            $table->string('address');
            $table->string('postcode');
            $table->string('city')->nullable();
            $table->unsignedBigInteger('area');
            $table->foreign('area')->references('id')->on('areas')->onDelete('cascade');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
