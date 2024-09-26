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
        Schema::table('rent_payments', function (Blueprint $table) {
            // Add the date_paid column if it doesn't already exist
            if (!Schema::hasColumn('rent_payments', 'date_paid')) {
                $table->date('date_paid')->nullable()->after('due_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_payments', function (Blueprint $table) {
            // Drop the date_paid column if it exists
            if (Schema::hasColumn('rent_payments', 'date_paid')) {
                $table->dropColumn('date_paid');
            }
        });
    }
};
