<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    protected $fillable = [
        'service_id',
        'professional_id', 
        'user_id',
        'rating',
        'comment',
        'reviews_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'reviews_count' => 'integer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}