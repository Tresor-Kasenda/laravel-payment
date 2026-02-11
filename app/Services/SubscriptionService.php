<?php

namespace App\Services;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionService
{
    public function createSubscription(
        User $user,
        string $planName,
        float $amount,
        string $provider,
        string|null $providerSubscriptionId,
        array $metadata = []
    ): Subscription {
        return DB::transaction(function () use ($user, $planName, $amount, $provider, $providerSubscriptionId, $metadata) {
            $now = now();
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_subscription_id' => $providerSubscriptionId ?? Str::uuid(),
                'plan_name' => $planName,
                'status' => SubscriptionStatus::Active,
                'started_at' => $now,
                'renews_at' => $now->clone()->addMonth(),
                'metadata' => array_merge($metadata, ['created_via' => 'seeded-service']),
            ]);

            $this->recordPayment(
                $subscription,
                amount: $amount,
                status: 'succeeded',
            );

            return $subscription;
        });
    }

    public function createSubscriptionFromTransaction(
        User $user,
        string $planName,
        float $amount,
        string $provider,
        object $transaction,
        array $metadata = []
    ): Subscription {
        return DB::transaction(function () use ($user, $planName, $amount, $provider, $transaction, $metadata) {
            $now = now();

            $status = $transaction->isCompleted()
                ? SubscriptionStatus::Active
                : SubscriptionStatus::PastDue;

            $subscription = Subscription::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_subscription_id' => $transaction->referenceId ?? Str::uuid(),
                'plan_name' => $planName,
                'status' => $status,
                'started_at' => $now,
                'renews_at' => $now->clone()->addMonth(),
                'metadata' => array_merge($metadata, [
                    'transaction_id' => $transaction->id,
                    'is_sandbox' => $transaction->isSandbox,
                ]),
            ]);

            $this->recordPayment(
                $subscription,
                amount: $amount,
                currency: $transaction->currency,
                status: $this->mapPaymentStatus($transaction->status->value),
            );

            return $subscription;
        });
    }

    public function cancelSubscription(Subscription $subscription, bool $immediate = true): Subscription
    {
        $subscription->update([
            'status' => SubscriptionStatus::Canceled,
            'renews_at' => null,
            'ends_at' => $immediate ? now() : $subscription->ends_at,
        ]);

        return $subscription;
    }

    public function recordPayment(Subscription $subscription, float $amount, string $currency = 'USD', string $status = 'pending'): SubscriptionPayment
    {
        return $subscription->payments()->create([
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
            'transaction_id' => Str::uuid(),
            'provider_payment_id' => Str::uuid(),
            'processed_at' => $status === 'pending' ? null : now(),
        ]);
    }

    private function mapPaymentStatus(string $transactionStatus): string
    {
        return match (strtolower($transactionStatus)) {
            'completed' => 'succeeded',
            'failed' => 'failed',
            default => 'pending',
        };
    }
}
