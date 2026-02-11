<?php

namespace App\Services;

use App\Enums\BlogPostStatus;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCreationService
{
    public function create(User $author, array $attributes): BlogPost
    {
        return DB::transaction(function () use ($author, $attributes): BlogPost {
            $slug = $this->ensureUniqueSlug($attributes['slug'] ?? null, $attributes['title'] ?? '');

            $data = [
                'author_id' => $author->id,
                'title' => trim($attributes['title']),
                'slug' => $slug,
                'excerpt' => $attributes['excerpt'] ?? null,
                'content' => $attributes['content'],
                'status' => $attributes['status'] ?? BlogPostStatus::Draft->value,
                'visible_to_subscribers_only' => $attributes['visible_to_subscribers_only'] ?? false,
                'published_at' => $attributes['published_at'] ?? null,
                'reading_time_minutes' => $attributes['reading_time_minutes'] ?? 5,
                'featured_image' => $attributes['featured_image'] ?? null,
            ];

            return BlogPost::create($data);
        });
    }

    protected function ensureUniqueSlug(?string $providedSlug, string $title): string
    {
        $base = Str::slug($providedSlug ?? $title) ?: Str::random(12);
        $candidate = $base;
        $counter = 1;

        while (BlogPost::where('slug', $candidate)->exists()) {
            $candidate = "{$base}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
