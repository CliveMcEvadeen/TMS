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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('terms')->nullable();
            $table->string('rent_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('penalty',10,2)->default(0);
            $table->integer('discount')->default(0);
            $table->decimal('amount',10,2)->default(0);
            $table->string('status')->default('new');
            $table->text('notes')->nullable();
            $table->string('property_id');
            $table->foreignId('tenants_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};