<?php

namespace App\Models;

use App\Enums\BooleanEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'status' => BooleanEnum::class
    ];


    /**
     * Scope to filter by name
     */
    public function scopeFilterName($query, $name)
    {
        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }
        return $query;
    }


    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($category) {
        //     if (empty($category->slug)) {
        //         $category->slug = Str::slug($category->name);
        //     }
        // });

        // static::updating(function ($category) {
        //     if ($category->isDirty('name')) {
        //         $category->slug = Str::slug($category->name);
        //     }
        // });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // Now routes will use slug instead of ID
    }

    public function scopeActive($query)
    {
        return $query->where('status', BooleanEnum::TRUE->value);
    }
    public function properties()
    {
        return $this->hasMany(Property::class, 'category_id');
    }

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    public function categoryType()
    {
        return $this->hasMany(Type::class, 'category_id', 'id')
            ->where('status', BooleanEnum::TRUE->value); // only active types;
    }

    public function activeTypes()
    {
        return $this->hasMany(Type::class)->active();
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }
}
