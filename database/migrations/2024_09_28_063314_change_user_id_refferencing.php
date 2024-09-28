<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Check if the user_id column does not exist, then add it
            if (!Schema::hasColumn('tenants', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Check if the user_id column exists, then drop it
            if (Schema::hasColumn('tenants', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
