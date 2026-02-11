<?php

namespace App\Models;

use App\Enums\BlogPostStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'visible_to_subscribers_only',
        'published_at',
        'reading_time_minutes',
        'featured_image',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'status' => BlogPostStatus::class,
            'visible_to_subscribers_only' => 'boolean',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', BlogPostStatus::Published);
    }

    public function scopeAccessibleForUser(Builder $query, ?User $user): Builder
    {
        if ($user && $user->hasActiveSubscription()) {
            return $query;
        }

        return $query->where('visible_to_subscribers_only', false);
    }
}
