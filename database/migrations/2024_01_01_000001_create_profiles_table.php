<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->json('subjects')->nullable();
            $table->json('age_groups')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->json('qualifications')->nullable();
            $table->timestamps();
        });

        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });

        // Add user_type to users table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['tutor', 'parent'])->after('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_profiles');
        Schema::dropIfExists('parent_profiles');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};