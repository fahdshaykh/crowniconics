<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use App\Enums\BillingCycle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'plan_id',
        'billing_cycle',
        'amount',
        'currency',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'canceled_at',
        'renewed_at',
        'next_billing_at',
        'status',
        'properties_used',
        'featured_used',
        'premium_used',
        'metadata',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'renewed_at' => 'datetime',
        'next_billing_at' => 'datetime',
        'amount' => 'decimal:2',
        'status' => SubscriptionStatus::class,
        'billing_cycle' => BillingCycle::class,
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the subscription
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan for this subscription
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    /**
     * Get payments for this subscription
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive()
    {
        return $this->status->isActive() && 
               ($this->ends_at === null || $this->ends_at->isFuture());
    }

    /**
     * Check if subscription is on trial
     */
    public function isOnTrial()
    {
        return $this->status->isOnTrial() && 
               $this->trial_ends_at && 
               $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired()
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    /**
     * Check if subscription is canceled
     */
    public function isCanceled()
    {
        return $this->status->isCanceled() || $this->canceled_at !== null;
    }

    /**
     * Get remaining property listings
     */
    public function getRemainingPropertiesAttribute()
    {
        if ($this->plan->hasUnlimitedProperties()) {
            return -1; // Unlimited
        }
        
        return max(0, $this->plan->property_listings - $this->properties_used);
    }

    /**
     * Get remaining featured listings
     */
    public function getRemainingFeaturedAttribute()
    {
        return max(0, $this->plan->featured_listings - $this->featured_used);
    }

    /**
     * Check if user can list more properties
     */
    public function canListProperty()
    {
        if (!$this->isActive()) {
            return false;
        }
        
        return $this->plan->hasUnlimitedProperties() || $this->remaining_properties > 0;
    }

    /**
     * Check if user can create featured listing
     */
    public function canCreateFeatured()
    {
        if (!$this->isActive()) {
            return false;
        }
        
        return $this->remaining_featured > 0;
    }

    /**
     * Increment property usage
     */
    public function incrementPropertyUsage()
    {
        $this->increment('properties_used');
    }

    /**
     * Increment featured usage
     */
    public function incrementFeaturedUsage()
    {
        $this->increment('featured_used');
    }

    /**
     * Get days until expiration
     */
    public function getDaysUntilExpirationAttribute()
    {
        if (!$this->ends_at) {
            return null;
        }
        
        return max(0, Carbon::now()->diffInDays($this->ends_at, false));
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', SubscriptionStatus::ACTIVE)
                    ->where(function($q) {
                        $q->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                    });
    }

    /**
     * Scope for expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where('ends_at', '<', now());
    }
}
