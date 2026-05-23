<?php

use App\Enums\BooleanEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('subscription_plans')->restrictOnDelete();
            
            // Billing Cycle
            $table->string('billing_cycle')->default('monthly');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            
            // Dates    
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('renewed_at')->nullable();
            // Optional: for auto-renew billing logic
            $table->timestamp('next_billing_at')->nullable();
            
            // Status
            $table->string('status')->default('pending');
            
            // Usage Tracking
            $table->integer('properties_used')->default(0);
            $table->integer('featured_used')->default(0);
            $table->integer('premium_used')->default(0);
            
            // Metadata (for flexible Stripe webhook data)
            $table->json('metadata')->nullable();
            
            // Timestamps & Soft Deletes
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for fast queries
            $table->index(['user_id', 'status']);
            $table->index(['status', 'ends_at']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
