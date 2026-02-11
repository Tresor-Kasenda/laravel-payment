<?php

namespace App\Http\Livewire;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SubscriptionDashboard extends Component
{
    public ?string $statusMessage = null;

    protected SubscriptionService $subscriptionService;

    public function boot(SubscriptionService $subscriptionService): void
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function getCurrentSubscriptionProperty(): ?Subscription
    {
        return auth()->user()?->activeSubscription();
    }

    public function render(): View
    {
        return view('livewire.subscription-dashboard', [
            'subscription' => $this->currentSubscription,
        ]);
    }

    public function startCheckout(): void
    {
        $user = auth()->user();

        if (! $user) {
            $this->statusMessage = 'Connectez-vous pour créer un abonnement.';
            return;
        }

        $subscription = $this->subscriptionService->createSubscription(
            $user,
            'Mensuel Premium',
            19.00,
        );

        $this->statusMessage = "Abonnement \"{$subscription->plan_name}\" créé (statut : {$subscription->status->value}).";
    }

    public function cancelSubscription(): void
    {
        if (! $this->currentSubscription) {
            $this->statusMessage = 'Aucun abonnement actif à annuler.';
            return;
        }

        $this->subscriptionService->cancelSubscription($this->currentSubscription);
        $this->statusMessage = 'Votre abonnement a été annulé (statut mis à jour).';
    }

    public function refreshStatus(): void
    {
        $this->statusMessage = 'Statut rafraîchi.';
    }
}
