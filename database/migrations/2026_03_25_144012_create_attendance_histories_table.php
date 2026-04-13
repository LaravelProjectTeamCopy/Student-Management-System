<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
            $table->date('semester_start')->nullable();
            $table->date('semester_end')->nullable();
            $table->integer('total_days')->nullable(); 
            $table->integer('present_days');
            $table->integer('absent_days');
            $table->string('status'); 
            $table->string('attendance_result');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_histories');
    }
};