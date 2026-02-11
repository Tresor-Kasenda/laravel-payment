<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_subscription_id',
        'plan_name',
        'status',
        'started_at',
        'trial_ends_at',
        'renews_at',
        'ends_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'status' => SubscriptionStatus::class,
            'started_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'renews_at' => 'datetime',
            'ends_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function isActive(): bool
    {
        return $this->status === SubscriptionStatus::Active
            || $this->status === SubscriptionStatus::Trialing;
    }

    public function scopeActive(Builder $query): Builder
    {
        $statuses = [
            SubscriptionStatus::Active->value,
            SubscriptionStatus::Trialing->value,
        ];

        return $query->whereIn('status', $statuses);
    }

    public function scopeActiveForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId)->active();
    }
}
