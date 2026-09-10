<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type', 20)->default('client')->after('is_admin');
            $table->string('profile_for', 30)->default('self')->after('user_type');
            $table->string('guardian_name', 100)->nullable()->after('profile_for');
            $table->foreignId('assigned_staff_id')->nullable()->after('guardian_name')->constrained('users')->nullOnDelete();
            $table->string('verification_status', 20)->default('pending')->after('assigned_staff_id');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->string('status', 20)->default('active')->after('verified_at');
            $table->text('suspension_reason')->nullable()->after('status');

            $table->index('user_type');
            $table->index('verification_status');
            $table->index('status');
        });

        DB::table('users')->where('is_admin', true)->update(['user_type' => 'staff']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['assigned_staff_id']);
            $table->dropIndex(['user_type']);
            $table->dropIndex(['verification_status']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'user_type',
                'profile_for',
                'guardian_name',
                'assigned_staff_id',
                'verification_status',
                'verified_at',
                'status',
                'suspension_reason',
            ]);
        });
    }
};
