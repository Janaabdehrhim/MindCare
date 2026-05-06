<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('therapist_id')->constrained('therapists')->onDelete('cascade');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->enum('status', ['available', 'booked', 'unavailable'])->default('available');
            $table->foreignId('session_id')->nullable()->constrained('patient_sessions')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
    }
};
