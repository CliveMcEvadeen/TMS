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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade'); // Link to tenants table
            $table->string('property_id')->change(); // Assuming you have properties table
            $table->decimal('amount', 10, 2); // Amount to be paid
            $table->string('payment_status')->default('pending'); // Payment status: pending, approved, rejected
            $table->timestamp('approved_at')->nullable(); // When landlord approves payment
            $table->timestamp('rejected_at')->nullable(); // When payment is rejected
            $table->timestamp('payment_date')->nullable(); // Date of the actual payment
            $table->text('payment_details')->nullable(); // Additional details about the payment
            $table->timestamps(); // Created_at and updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
