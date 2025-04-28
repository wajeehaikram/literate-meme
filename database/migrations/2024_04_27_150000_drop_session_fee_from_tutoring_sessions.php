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
        Schema::table('tutoring_sessions', function (Blueprint $table) {
            $table->dropColumn('session_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutoring_sessions', function (Blueprint $table) {
            $table->decimal('session_fee', 8, 2)->default(0);
        });
    }
};