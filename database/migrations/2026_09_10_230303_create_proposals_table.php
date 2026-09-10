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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sender_profile_id')->constrained('candidate_profiles')->cascadeOnDelete();
            $table->foreignId('receiver_profile_id')->constrained('candidate_profiles')->cascadeOnDelete();
            $table->string('status', 30)->default('pending')->index();
            $table->boolean('is_matchmaker_suggested')->default(false);
            $table->foreignId('assigned_staff_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('sender_message')->nullable();
            $table->text('matchmaker_internal_notes')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->index(['sender_user_id', 'status']);
            $table->index(['receiver_profile_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
