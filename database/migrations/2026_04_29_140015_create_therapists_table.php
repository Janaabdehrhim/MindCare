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
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('specialization');
            $table->string('language');
            $table->enum('rating', [1,2,3,4,5])->default(5);
            $table->boolean('is_available')->default(true);
            $table->decimal('wallet', 10, 2)->default(0.00);
            $table->decimal('session_fee', 10, 2)->default(0.00);
            $table->integer('total_patients')->default(0);
            $table->integer('total_sessions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapists');
    }
};
