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
        Schema::create('system_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action');        // e.g. "Created Student"
            $table->string('module');        // e.g. "Student", "Attendance", "Financial"
            $table->text('description')->nullable(); // e.g. "Created student John Doe (ID: 123)"
            $table->string('icon')->nullable();      // e.g. "person_add"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_histories');
    }
};
