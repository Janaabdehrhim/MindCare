<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_id')->constrained('therapists')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->dateTime('session_time');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'completed', 'canceled', 'rescheduled'])->default('scheduled');
            $table->enum('rating', [1, 2, 3, 4, 5])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_sessions');
    }
};
