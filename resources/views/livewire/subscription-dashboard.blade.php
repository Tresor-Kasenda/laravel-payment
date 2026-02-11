<div class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-700 shadow-sm">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-xs uppercase tracking-wide text-slate-500">Statut de l'abonnement</p>
            @if ($subscription)
                <p class="text-lg font-semibold text-slate-900">{{ $subscription->plan_name }}</p>
            @else
                <p class="text-lg font-semibold text-slate-900">Pas d'abonnement actif</p>
            @endif
        </div>
        <div class="text-right">
            <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700">
                @if ($subscription)
                    {{ ucfirst($subscription->status->value) }}
                @else
                    Inactif
                @endif
            </span>
        </div>
    </div>

    @if ($subscription)
        <div class="grid gap-2 text-slate-700">
            <p>Renouvellement prévu le <strong class="text-slate-900">{{ $subscription->renews_at?->format('d/m/Y') ?? '—' }}</strong></p>
            <p>Date de fin anticipée : <strong class="text-slate-900">{{ $subscription->ends_at?->format('d/m/Y') ?? 'non réglée' }}</strong></p>
        </div>
    @else
        <p class="text-slate-600">Créez un abonnement mensuel pour débloquer les articles réservés aux abonnés.</p>
    @endif

    <div class="flex flex-wrap gap-3 pt-2">
        <button wire:click="startCheckout" wire:loading.attr="disabled" class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-100">
            Simuler l'abonnement
        </button>
        <button wire:click="cancelSubscription" wire:loading.attr="disabled" class="rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-rose-800 transition hover:border-rose-300 hover:bg-rose-100">
            Annuler l’abonnement
        </button>
        <button wire:click="refreshStatus" wire:loading.attr="disabled" class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">
            Rafraîchir
        </button>
    </div>

    <div wire:loading class="text-xs text-slate-500" wire:target="startCheckout,cancelSubscription,refreshStatus">Traitement...</div>

    @if ($statusMessage)
        <p class="text-xs text-amber-700">{{ $statusMessage }}</p>
    @endif
</div>
