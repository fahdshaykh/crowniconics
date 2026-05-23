<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\BooleanEnum;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => BooleanEnum::class,
    ];

    public function isActive(): bool
    {
        return $this->status === BooleanEnum::TRUE;
    }

    public function scopeActive($query)
    {
        return $query->where('status', BooleanEnum::TRUE->value);
    }

    public function toggleStatus(): bool
    {
        $newStatus = $this->status === BooleanEnum::TRUE 
            ? BooleanEnum::FALSE 
            : BooleanEnum::TRUE;
            
        return $this->update(['status' => $newStatus->value]);
    }

    public function getPartnerImageAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('partners/images/partner-1.png');
    }
}