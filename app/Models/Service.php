<?php

namespace App\Models;

use App\Enums\BooleanEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type_id',
        'title',
        'slug',
        'description',
        'image',
        'status',
    ];

    // Fix the enum casting
    protected $casts = [
        'status' => BooleanEnum::class,
    ];

    // Add this to prevent the issue
    public function scopeActive($query)
    {
        return $query->where('status', BooleanEnum::TRUE->value);
    }

    // Better toggle method
    public function toggleStatus(): bool
    {
        $newStatus = $this->status === BooleanEnum::TRUE 
            ? BooleanEnum::FALSE 
            : BooleanEnum::TRUE;
            
        return $this->update(['status' => $newStatus->value]);
    }

    // Helper method
    public function isActive(): bool
    {
        return $this->status === BooleanEnum::TRUE;
    }

    // Rest of your model methods...
    public function getServiceImageAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.jpg');
    }

    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
            // Ensure user_id is set when creating
            if (empty($service->user_id)) {
                $service->user_id = auth()->id();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function professionals()
    {
        return $this->belongsToMany(User::class, 'professional_service', 'service_id', 'professional_id')
            ->withPivot('personal_information', 'experience_years', 'status', 'images')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(ServiceReview::class, 'service_id');
    }
}