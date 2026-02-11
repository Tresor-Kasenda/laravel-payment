<?php

namespace App\Http\Controllers;

use Shwary\Config;
use Shwary\Shwary;
use Shwary\ShwaryClient;
use Shwary\Enums\Country;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        return view('subscription', [
            'subscription' => $request->user()?->activeSubscription(),
        ]);
    }

    public function store(StoreSubscriptionRequest $request, SubscriptionService $service): RedirectResponse
    {

        return redirect()->route('subscription.dashboard')->with('status', 'Abonnement créé avec succès. Vous pouvez suivre votre statut ci-dessous.');
    }

    public function cancel(Request $request, SubscriptionService $service): RedirectResponse
    {
        $subscription = $request->user()?->activeSubscription();

        if (! $subscription) {
            return redirect()->route('subscription.dashboard')->with('status', 'Aucun abonnement actif à annuler.');
        }

        $service->cancelSubscription($subscription);

        return redirect()->route('subscription.dashboard')->with('status', 'Votre abonnement a été annulé.');
    }
}
