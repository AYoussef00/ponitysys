<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'description',
        'type',
        'value',
        'points_required',
        'usage_limit',
        'used_count',
        'minimum_purchase',
        'starts_at',
        'expires_at',
        'eligibility_start',
        'eligibility_end',
        'status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'eligibility_start' => 'datetime',
        'eligibility_end' => 'datetime',
        'value' => 'decimal:2'
    ];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // التحقق من صلاحية الكوبون
    public function isValid()
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        $now = now();
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        // تحقق من فترة الاستحقاق
        if ($this->eligibility_start && $now->lt($this->eligibility_start)) {
            return false;
        }
        if ($this->eligibility_end && $now->gt($this->eligibility_end)) {
            return false;
        }

        return true;
    }

    // حساب قيمة الخصم
    public function calculateDiscount($amount)
    {
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }

        return ($amount * $this->value) / 100;
    }
}
