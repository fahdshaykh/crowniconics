<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'payment_method',
        'amount',
        'tax_amount',
        'total_amount',
        'currency',
        'status',
        'type',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_zip_code',
        'paid_at',
        'refunded_at',
        'failed_at',
        'failure_code',
        'failure_message',
        'metadata',
        'payment_method_details',
        // M-Pesa specific fields
        'mpesa_receipt_number',
        'mpesa_transaction_id',
        'mpesa_phone_number',
        'mpesa_account_reference',
        'mpesa_transaction_description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'failed_at' => 'datetime',
        'status' => PaymentStatus::class,
        'type' => PaymentType::class,
        'metadata' => 'array',
        'payment_method_details' => 'array',
    ];

    /**
     * Get the user that made the payment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription for this payment
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful()
    {
        return $this->status->isSuccessful();
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status->isPending();
    }

    /**
     * Check if payment failed
     */
    public function isFailed()
    {
        return $this->status->isFailed();
    }

    /**
     * Check if payment is refunded
     */
    public function isRefunded()
    {
        return $this->status->isRefunded();
    }

    /**
     * Scope for successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', PaymentStatus::SUCCEEDED);
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', [PaymentStatus::PENDING, PaymentStatus::PROCESSING]);
    }

    /**
     * Scope for failed payments
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', [PaymentStatus::FAILED, PaymentStatus::CANCELED]);
    }

    /**
     * Scope for M-Pesa payments
     */
    public function scopeMpesa($query)
    {
        return $query->where('payment_method', 'mpesa');
    }

    /**
     * Get formatted amount for display
     */
    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    /**
     * Get formatted total amount for display
     */
    public function getFormattedTotalAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->total_amount, 2);
    }
}
