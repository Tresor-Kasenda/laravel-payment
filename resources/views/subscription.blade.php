<x-layouts.app>
    <div class="space-y-6">
        <header class="rounded-3xl border border-slate-200 bg-white p-8 text-slate-800 shadow-sm">
            <h1 class="text-3xl font-semibold text-slate-900">Gérer l'abonnement</h1>
            <p class="text-sm text-slate-600">
                Suivez votre statut actuel et déclenchez un paiement fictif ou une annulation directement depuis cette page.
            </p>
        </header>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Statut actuel</p>
                @if ($subscription)
                    <div class="mt-4 space-y-2 text-sm text-slate-700">
                        <p class="text-lg font-semibold text-slate-900">{{ $subscription->plan_name }}</p>
                        <p>Status : <strong class="text-emerald-700">{{ ucfirst($subscription->status->value) }}</strong></p>
                        <p>Renouvellement prévu : {{ $subscription->renews_at?->format('d/m/Y') ?? '—' }}</p>
                        <p>Fin anticipée : {{ $subscription->ends_at?->format('d/m/Y') ?? 'non définie' }}</p>
                    </div>
                @else
                    <p class="mt-4 text-sm text-slate-700">Aucun abonnement actif pour le moment.</p>
                @endif
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Actions</h2>
                <p class="mt-2 text-sm text-slate-600">Créez un abonnement factice ou annulez l’existant.</p>

                <form action="{{ route('subscription.subscribe') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="plan_name" value="Mensuel Premium" />
                    <input type="hidden" name="amount" value="19.00" />

                    <button type="submit" class="w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-100">
                        Créer un abonnement mensuel
                    </button>
                </form>

                <form action="{{ route('subscription.cancel') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-rose-800 transition hover:border-rose-300 hover:bg-rose-100">
                        Annuler mon abonnement
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
