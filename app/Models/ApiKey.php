<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'key',
        'type',
        'is_active',
        'last_used_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    public static function generateKey(): string
    {
        return 'sk_' . (config('app.env') === 'production' ? 'live' : 'test') . '_' . Str::random(32);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsUsed()
    {
        $this->update(['last_used_at' => now()]);
    }
}
