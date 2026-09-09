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
        Schema::create('consultation_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_code')->unique();
            $table->string('looking_for');
            $table->string('profile_for');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('city')->nullable();
            $table->string('desher_bari')->nullable();
            $table->string('preferred_package')->nullable();
            $table->string('annual_income')->nullable();
            $table->text('message')->nullable();
            $table->string('status', 50)->default('Pending Review')->index();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_inquiries');
    }
};
