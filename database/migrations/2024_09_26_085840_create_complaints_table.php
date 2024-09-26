<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id'); // Foreign key to tenants
            $table->string('complaint_code', 10)->unique(); // Unique complaint code (T/C-XXXXXX)
            $table->string('room_number');
            $table->string('block');
            $table->string('location');
            $table->string('telephone_number');
            $table->text('description');
            $table->enum('status', ['pending', 'resolved'])->default('pending'); // Complaint status
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}
