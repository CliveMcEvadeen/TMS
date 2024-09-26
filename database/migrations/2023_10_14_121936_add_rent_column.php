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
        // Check if the column already exists
        if (!Schema::hasColumn('rents', 'deposit')) {
            Schema::table('rents', function (Blueprint $table) {
                $table->decimal('deposit', 10, 2)->nullable()->after('discount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the column if it exists
        if (Schema::hasColumn('rents', 'deposit')) {
            Schema::table('rents', function (Blueprint $table) {
                $table->dropColumn('deposit');
            });
        }
    }
};
