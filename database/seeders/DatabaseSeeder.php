<?php

namespace Database\Seeders;

use App\Enums\BlogPostStatus;
use App\Enums\SubscriptionStatus;
use App\Models\BlogPost;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin = User::factory()->admin()->create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $reader = User::factory()->create([
            'name' => 'Lecteur abonné',
            'email' => 'reader@example.com',
            'password' => Hash::make('password'),
        ]);

        BlogPost::factory()
            ->count(10)
            ->state(fn (array $attributes) => [
                'status' => BlogPostStatus::Published,
                'visible_to_subscribers_only' => false,
            ])
            ->for($admin, 'author')
            ->create();

        BlogPost::factory()
            ->count(10)
            ->state(fn (array $attributes) => [
                'status' => BlogPostStatus::Published,
                'visible_to_subscribers_only' => true,
            ])
            ->for($admin, 'author')
            ->create();

        $subscription = Subscription::factory()
            ->state([
                'user_id' => $reader->id,
                'status' => SubscriptionStatus::Active,
            ])
            ->create();

        SubscriptionPayment::factory()
            ->count(2)
            ->state(['subscription_id' => $subscription->id, 'status' => 'succeeded'])
            ->create();
    }
}
