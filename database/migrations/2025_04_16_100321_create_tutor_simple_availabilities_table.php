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
        Schema::create('tutor_simple_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the users table
            $table->json('availability')->nullable(); // Store availability grid as JSON
            // Example JSON structure: 
            // {
            //   "mon": ["pre_12pm", "after_5pm"],
            //   "tue": ["12_5pm"],
            //   ...
            // }
            $table->integer('hours_per_week')->nullable(); // Store preferred hours
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_simple_availabilities');
    }
};
