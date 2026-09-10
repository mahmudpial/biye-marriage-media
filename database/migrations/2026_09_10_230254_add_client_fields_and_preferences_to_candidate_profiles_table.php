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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('full_name', 100)->nullable()->after('user_id');
            $table->string('approval_status', 20)->default('approved')->after('is_active');
            $table->text('admin_notes')->nullable()->after('approval_status');
            $table->unsignedTinyInteger('completion_score')->default(85)->after('admin_notes');

            // Partner Preferences
            $table->unsignedTinyInteger('pref_age_min')->nullable()->after('completion_score');
            $table->unsignedTinyInteger('pref_age_max')->nullable()->after('pref_age_min');
            $table->string('pref_height_min', 20)->nullable()->after('pref_age_max');
            $table->string('pref_height_max', 20)->nullable()->after('pref_height_min');
            $table->string('pref_education', 100)->nullable()->after('pref_height_max');
            $table->string('pref_profession', 100)->nullable()->after('pref_education');
            $table->string('pref_desher_bari', 100)->nullable()->after('pref_profession');
            $table->string('pref_marital_status', 50)->nullable()->after('pref_desher_bari');
            $table->string('pref_religion', 60)->nullable()->after('pref_marital_status');

            $table->index('user_id');
            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['approval_status']);
            $table->dropColumn([
                'user_id',
                'full_name',
                'approval_status',
                'admin_notes',
                'completion_score',
                'pref_age_min',
                'pref_age_max',
                'pref_height_min',
                'pref_height_max',
                'pref_education',
                'pref_profession',
                'pref_desher_bari',
                'pref_marital_status',
                'pref_religion',
            ]);
        });
    }
};
