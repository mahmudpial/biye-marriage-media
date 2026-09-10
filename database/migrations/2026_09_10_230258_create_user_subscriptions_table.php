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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('membership_packages')->nullOnDelete();
            $table->string('package_name', 100)->default('Complimentary Access');
            $table->decimal('price_paid', 10, 2)->default(0.00);
            $table->unsignedInteger('proposals_quota')->default(5);
            $table->unsignedInteger('proposals_used')->default(0);
            $table->unsignedInteger('contact_views_quota')->default(0);
            $table->unsignedInteger('contact_views_used')->default(0);
            $table->string('status', 20)->default('active')->index();
            $table->timestamp('starts_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
