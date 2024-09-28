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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('tenant_id')->nullable()->after('id'); // Make tenant ID nullable initially
            $table->string('password')->after('email')->nullable(); // Add password field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('tenant_id'); // Drop tenant ID field
            $table->dropColumn('password'); // Drop password field
        });
    }
};
