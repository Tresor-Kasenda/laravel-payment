<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubscriptionPayment>
 */
class SubscriptionPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'succeeded', 'failed']);

        return [
            'subscription_id' => Subscription::factory(),
            'amount' => fake()->randomFloat(2, 5, 120),
            'currency' => 'USD',
            'status' => $status,
            'transaction_id' => fake()->uuid(),
            'provider_payment_id' => fake()->uuid(),
            'processed_at' => $status === 'pending' ? null : fake()->dateTimeBetween('-10 days', 'now'),
        ];
    }
}
