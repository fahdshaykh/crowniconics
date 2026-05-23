<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'category_id',
        'type_id',
        'user_id',
        'slug',
        'title',
        'meta_title',
        'description',
        'is_active',
        'status',
        'country_id',
        'state_id',
        'city_id',
        'zip_code',
        'address',
        'price',
        'currency',
        'reference_number',
        'price_type',
        'beds',
        'bathrooms',
        'area_sqft',
        'parking',
        'featured_image',
        'images',
        'video_url',
        'features',
        'is_featured'
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'area_sqft' => 'decimal:2',
        'beds' => 'integer',
        'bathrooms' => 'integer',
        'parking' => 'integer',
    ];

    protected $appends = [
        'featured_image_url',
        'images_urls',
        'features_array',
        'first_image_url'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function parent()
    {
        return $this->belongsTo(Property::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Property::class, 'parent_id');
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return $this->getDefaultImageUrl();
        }

        return Storage::disk('public')->exists($this->featured_image)
            ? Storage::disk('public')->url($this->featured_image)
            : $this->getDefaultImageUrl();
    }

    public function getImagesUrlsAttribute()
    {
        if (empty($this->images) || !is_array($this->images)) {
            return [];
        }

        $urls = [];
        foreach ($this->images as $image) {
            if (Storage::disk('public')->exists($image)) {
                $urls[] = Storage::disk('public')->url($image);
            }
        }

        return $urls;
    }

    public function getFeaturesArrayAttribute()
    {
        if (empty($this->features)) {
            return [];
        }

        if (is_string($this->features)) {
            $features = explode(',', $this->features);
            return array_map('trim', array_filter($features));
        }

        if (is_array($this->features)) {
            return array_filter($this->features);
        }

        return [];
    }

    public function getFirstImageUrlAttribute()
    {
        if ($this->featured_image_url && $this->featured_image_url !== $this->getDefaultImageUrl()) {
            return $this->featured_image_url;
        }

        if (!empty($this->images_urls)) {
            return $this->images_urls[0];
        }

        return $this->getDefaultImageUrl();
    }

    // Methods for checking images
    public function hasImages()
    {
        return !empty($this->images) && is_array($this->images) && count($this->images) > 0;
    }

    public function hasMultipleImages()
    {
        return $this->hasImages() && count($this->images) > 1;
    }

    public function getImageCount()
    {
        if (!$this->hasImages()) {
            return 0;
        }

        return count($this->images);
    }

    // Helper method for default image
    protected function getDefaultImageUrl()
    {
        return asset('images/default-property.jpg');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Price scopes
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('type_id', $typeId);
    }

    public function scopeBedrooms($query, $bedrooms)
    {
        return $query->where('beds', $bedrooms);
    }

    // Other useful methods
    public function isAvailable()
    {
        return $this->status === 'available' && $this->is_active;
    }

    public function isFeatured()
    {
        return $this->is_featured;
    }

    public function getFormattedPrice()
    {
        $formatted = '$' . number_format($this->price, 2);

        if ($this->price_type === 'per_month') {
            $formatted .= '/month';
        } elseif ($this->price_type === 'negotiable') {
            $formatted .= ' (Negotiable)';
        }

        return $formatted;
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'available' => 'bg-success',
            'sold' => 'bg-danger',
            'rented' => 'bg-info',
            'pending' => 'bg-warning',
            'draft' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }
    private function getLocationDisplay($property)
    {
        $location = [];
        if ($property->city) $location[] = $property->city->name;
        if ($property->state) $location[] = $property->state->name;
        if ($property->country) $location[] = $property->country->name;

        return implode(', ', $location) ?: 'Location not set';
    }

    public function changeStatus($newStatus)
    {
        $allowedStatuses = ['available', 'sold', 'rented', 'pending', 'draft'];

        if (!in_array($newStatus, $allowedStatuses)) {
            return false;
        }

        $this->update(['status' => $newStatus]);

        return true;
    }

    public static function getAllowedStatuses()
    {
        return [
            'available' => 'Available',
            'sold' => 'Sold',
            'rented' => 'Rented',
            'pending' => 'Pending',
            'draft' => 'Draft'
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            $property->slug = Str::slug($property->title);
        });
    }
}
