<?php

namespace App\Models;

use App\Enums\BooleanEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'category_id',
    ];

    protected $casts = [
        'status' => \App\Enums\BooleanEnum::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', BooleanEnum::TRUE->value);
    }

    public function categoryDetail()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    // Add scope for filtering by main category
    public function scopeWhereMainCategory($query, $mainCategoryId)
    {
        return $query->whereHas('category', function ($query) use ($mainCategoryId) {
            $query->where('main_category_id', $mainCategoryId);
        });
    }

    // public function propertiesType()
    // {
    //     return $this->belongsTo(Category::class, 'id')->where('main_category_id', 1);
    // }

    // public function servicesType()
    // {
    //     return $this->belongsTo(Category::class, 'id')->where('main_category_id', 2);
    // }
}
