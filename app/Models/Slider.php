<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'type_id',
        'title',
        'description',
        'note',
        'image',
        'status',
    ];

    public function getSliderImageAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('sliders/images/sample1.jpg');
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
