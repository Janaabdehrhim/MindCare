<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('description');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->integer('progress_days')->default(0);
            $table->integer('target_days')->default(5);
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
