<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void
    {
        Schema::create('wellness_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->integer('mood_score')->nullable();
            $table->decimal('sleep_quality', 4, 1)->nullable();
            $table->text('journal_entry')->nullable();
            $table->enum('visibility', ['private', 'therapist_only', 'public'])->default('private');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wellness_records');
    }
};
