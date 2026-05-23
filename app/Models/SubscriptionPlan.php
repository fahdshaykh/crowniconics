<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'monthly_price',
        'yearly_price',
        'setup_fee',
        'currency',
        'property_listings',
        'featured_listings',
        'premium_listings',
        'agent_profiles',
        'professional_profiles',
        'storage_space_mb',
        'analytics',
        'support_priority',
        'features',
        'trial_days',
        'billing_cycle_days',
        'auto_renew',
        'is_active',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'analytics' => 'boolean',
        'support_priority' => 'boolean',
        'auto_renew' => 'boolean',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
    ];

    /**
     * Get active plans ordered by sort order
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get popular plans
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Get subscriptions for this plan
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    /**
     * Get active subscriptions for this plan
     */
    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('status', 'active');
    }

    /**
     * Check if plan has unlimited property listings
     */
    public function hasUnlimitedProperties()
    {
        return $this->property_listings === -1;
    }

    /**
     * Get formatted price for display
     */
    public function getFormattedPriceAttribute()
    {
        return $this->currency . ' ' . number_format($this->monthly_price, 2);
    }

    /**
     * Get yearly savings percentage
     */
    public function getYearlySavingsAttribute()
    {
        if ($this->yearly_price <= 0 || $this->monthly_price <= 0) {
            return 0;
        }
        
        $monthlyTotal = $this->monthly_price * 12;
        $savings = $monthlyTotal - $this->yearly_price;
        
        return round(($savings / $monthlyTotal) * 100);
    }
}
