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
        Schema::create('financial_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('semester_start')->nullable();
            $table->date('semester_end')->nullable();
            $table->decimal('total_fees', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->decimal('balance_remaining', 10, 2)->nullable();
            $table->string('payment_status');
            $table->date('payment_date')->nullable();
            $table->integer('overdue_since')->nullable();
            $table->integer('overdue_days')->default(0);
            $table->date('deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_histories');
    }
};
