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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('offer_title');
            $table->longText('offer_description');
            $table->string('affiliate_link');
            $table->double('offer_amount')->nullable();
            $table->string('offer_percentage')->nullable();
            $table->string('QR_code')->nullable();
            $table->string('affiliate_url')->nullable();
            $table->text('offer_image');
            $table->text('banner_image');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('subCategory_id');
            $table->foreign('subCategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->unsignedBigInteger('qr_code_id')->nullable();
            $table->foreign('qr_code_id')->references('id')->on('qrcodes')->onDelete('cascade');
            $table->double('minimum_perchase');
            // $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            // $table->unsignedBigInteger('brand_id')->nullable();
            // $table->foreign('brand_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('brand_name')->nullable();
            $table->foreign('brand_name')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('placeName')->nullable();
            $table->foreign('placeName')->references('id')->on('rate_of_prices')->onDelete('cascade');
            $table->unsignedBigInteger('placeRate')->nullable();
            $table->foreign('placeRate')->references('id')->on('rate_of_prices')->onDelete('cascade');
            $table->enum('status',['true','false'])->default('false')->nullable();
            $table->string('clicks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
