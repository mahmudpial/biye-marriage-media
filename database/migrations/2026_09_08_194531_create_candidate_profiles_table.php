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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('profile_code', 50)->unique();
            $table->string('gender', 10);
            $table->unsignedTinyInteger('age');
            $table->string('height', 20);
            $table->string('religion', 60)->default('Islam (Sunni)');
            $table->string('desher_bari', 100);
            $table->string('education');
            $table->string('profession');
            $table->string('location');
            $table->string('income');
            $table->string('category', 60)->default('Elite Professional');
            $table->text('family');
            $table->string('image')->nullable();
            $table->boolean('is_discreet')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'gender']);
            $table->index(['is_active', 'is_featured']);
            $table->index('desher_bari');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
