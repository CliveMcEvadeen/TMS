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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');  // Assuming you have a tenants table
            $table->foreignId('property_id')->constrained('properties');  // Assuming you have a properties table
            $table->string('issue_type');  // E.g., 'Plumbing', 'Electrical', 'Other'
            $table->text('description');
            $table->enum('urgency', ['Low', 'Medium', 'High'])->default('Low');
            $table->enum('status', ['Pending', 'In Progress', 'Resolved'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
