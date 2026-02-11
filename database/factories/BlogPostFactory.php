<?php

namespace Database\Factories;

use App\Enums\BlogPostStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);
        $status = fake()->randomElement(BlogPostStatus::cases());

        return [
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(22),
            'content' => fake()->paragraphs(5, true),
            'status' => $status,
            'visible_to_subscribers_only' => fake()->boolean(40),
            'published_at' => $status === BlogPostStatus::Published
                ? fake()->dateTimeBetween('-30 days', '+7 days')
                : null,
            'reading_time_minutes' => fake()->numberBetween(3, 18),
            'featured_image' => fake()->optional(0.6)->imageUrl(1200, 600, 'nature', true),
        ];
    }
}
