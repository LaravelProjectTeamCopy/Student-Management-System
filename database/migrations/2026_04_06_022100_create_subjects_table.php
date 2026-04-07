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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_code');           // e.g., CS101, LIT202
            $table->string('name');                   // e.g., Literature, Math
            $table->string('major');                  // e.g., Computer Science, Arts
            $table->integer('credits')->default(3);
            $table->string('academic_year');          // e.g., 2025/2026
            $table->string('semester');              // e.g., Semester 1
            $table->timestamps();

            // Unique per major + year + semester — same code can't appear twice in same period
            $table->unique(['subject_code', 'major', 'academic_year', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
