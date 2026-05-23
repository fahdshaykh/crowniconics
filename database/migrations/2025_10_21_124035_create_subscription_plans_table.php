<?php

use App\Enums\BooleanEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Pricing
            $table->decimal('monthly_price', 10, 2)->default(0);
            $table->decimal('yearly_price', 10, 2)->default(0);
            $table->decimal('setup_fee', 10, 2)->default(0);
            $table->string('currency', 3)->default('KES');
            
            // Features & Limits
            $table->integer('property_listings')->default(0);
            $table->integer('featured_listings')->default(0);
            $table->integer('premium_listings')->default(0);
            $table->boolean('analytics')->default(false);
            $table->boolean('support_priority')->default(false);
            $table->json('features')->nullable();
            
            // Billing
            $table->integer('trial_days')->default(0);
            $table->integer('billing_cycle_days')->default(30);
            $table->boolean('auto_renew')->default(true);
            
            // Status
            $table->boolean('is_active')->default(BooleanEnum::TRUE->value);
            $table->boolean('is_popular')->default(BooleanEnum::FALSE->value);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['is_active', 'sort_order']);
            $table->index('monthly_price');
            $table->index('yearly_price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};