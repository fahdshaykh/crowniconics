<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'country_id',
        'city_id',
        'state_id',
        'zip_code',
        'address',
        'profile_image',
        'role',
        'email_verified_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get the user's profile image URL
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('dashboard/assets/images/avatars/02.png');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    /**
     * Check if user is agent
     */
    public function isAgent()
    {
        return $this->role === 'agent' || $this->hasRole('agent');
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'professional_service', 'professional_id', 'service_id')
            ->withPivot('personal_information', 'experience_years', 'status', 'images')
            ->withTimestamps();
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function serviceReviews()
    {
        return $this->hasMany(\App\Models\ServiceReview::class, 'professional_id');
    }

    /**
     * Get user's subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get user's active subscription
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')
                    ->where(function($q) {
                        $q->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                    });
    }

    /**
     * Get user's payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription()
    {
        // Admin users don't need subscriptions - they have full access
        if ($this->hasRole('admin')) {
            return true;
        }
        
        return $this->activeSubscription()->exists();
    }

    /**
     * Get current subscription
     */
    public function getCurrentSubscription()
    {
        // Admin users don't need subscriptions - return null
        if ($this->hasRole('admin')) {
            return null;
        }
        
        return $this->activeSubscription;
    }

    /**
     * Check if user can list properties
     */
    public function canListProperty()
    {
        // Admin users can always list properties
        if ($this->hasRole('admin')) {
            return true;
        }
        
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return false;
        }
        
        return $subscription->canListProperty();
    }

    /**
     * Check if user can create featured listing
     */
    public function canCreateFeatured()
    {
        // Admin users can always create featured listings
        if ($this->hasRole('admin')) {
            return true;
        }
        
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return false;
        }
        
        return $subscription->canCreateFeatured();
    }

    /**
     * Get remaining property listings
     */
    public function getRemainingProperties()
    {
        // Admin users have unlimited properties
        if ($this->hasRole('admin')) {
            return -1; // Unlimited
        }
        
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return 0;
        }
        
        return $subscription->remaining_properties;
    }

 
    public function getRemainingFeatured()
    {

        if ($this->hasRole('admin')) {
            return -1; // Unlimited
        }
        
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return 0;
        }
        
        return $subscription->remaining_featured;
    }
}
