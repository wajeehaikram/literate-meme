<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutoring_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->text('subject');
            $table->text('notes')->nullable();
            $table->decimal('session_fee', 8, 2);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        Schema::create('session_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutoring_session_id')->constrained()->onDelete('cascade');
            $table->boolean('attended')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('session_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutoring_session_id')->constrained()->onDelete('cascade');
            $table->text('feedback_content');
            $table->integer('rating')->nullable();
            $table->enum('feedback_from', ['tutor', 'parent']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_feedback');
        Schema::dropIfExists('session_attendance');
        Schema::dropIfExists('tutoring_sessions');
    }
};