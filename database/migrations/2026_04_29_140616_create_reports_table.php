<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('therapist_id')->nullable()->constrained('therapists')->onDelete('set null');
            $table->foreignId('intake_form_id')->constrained('intake_forms')->onDelete('cascade');
            $table->integer('total_score')->default(0);
            $table->enum('condition_level', ['low', 'medium', 'high', 'severe'])->default('low');
            $table->string('recommended_specialization')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
