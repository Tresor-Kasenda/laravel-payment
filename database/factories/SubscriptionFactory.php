<?php

namespace Database\Factories;

use App\Enums\SubscriptionStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $status = fake()->randomElement(SubscriptionStatus::cases());
        $startedAt = fake()->dateTimeBetween('-120 days', '-30 days');
        $renewsAt = (clone $startedAt)->modify('+30 days');

        $trialEndsAt = $status === SubscriptionStatus::Trialing
            ? fake()->dateTimeBetween('now', '+10 days')
            : null;

        return [
            'user_id' => User::factory(),
            'provider' => 'stripe',
            'provider_subscription_id' => fake()->uuid(),
            'plan_name' => fake()->randomElement(['Mensuel Premium', 'Soutien', 'Accès Illimité']),
            'status' => $status,
            'started_at' => $startedAt,
            'trial_ends_at' => $trialEndsAt,
            'renews_at' => $renewsAt,
            'ends_at' => $status === SubscriptionStatus::Expired
                ? fake()->dateTimeBetween('-10 days', 'now')
                : null,
            'metadata' => [
                'source' => 'seed',
                'region' => fake()->countryCode(),
            ],
        ];
    }
}
