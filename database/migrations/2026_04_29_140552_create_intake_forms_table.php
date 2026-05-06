<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void
    {
        Schema::create('intake_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->integer('stress_score')->default(0);
            $table->integer('anxiety_score')->default(0);
            $table->integer('sleep_score')->default(0);
            $table->integer('mood_score')->default(0);
            $table->integer('social_score')->default(0);
            $table->integer('trauma_score')->default(0);
            $table->integer('self_care_score')->default(0);
            $table->enum('overall_level', ['low', 'medium', 'high', 'severe'])->default('low');
            $table->string('recommended_specialization')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_forms');
    }
};
