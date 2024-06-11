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
        Schema::create('customer_services', function (Blueprint $table) {
            $table->id();
            $table->string('issue');
            $table->text('retailer_name');
            $table->dateTime('date_time');
            $table->string('offer_type');
            $table->double('purchase_amount');
            $table->string('confirm_number');
            $table->string('discount_coupon');
            $table->date('check_in');
            $table->date('check_out');
            $table->enum('status',['true','false'])->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_services');
    }
};
