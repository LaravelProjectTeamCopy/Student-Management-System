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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->integer('total_days')->unsigned();
            $table->integer('present_days')->unsigned();
            $table->integer('absent_days')->unsigned();
            $table->string('status')->default('Critical');
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
            $table->date('semester_start')->nullable();
            $table->integer('semester_duration')->nullable();
            $table->date('deadline')->nullable();
            $table->string('attendance_result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
