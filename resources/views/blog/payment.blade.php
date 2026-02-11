<x-layouts.app>
    <div class="space-y-6">
        <header class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Paiement requis</p>
            <h1 class="mt-1 text-3xl font-semibold text-slate-900">{{ $blogPost->title }}</h1>
            <p class="mt-3 text-sm text-slate-600">{{ $blogPost->excerpt }}</p>

            @if(session('payment_prompt'))
                <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 px-6 py-4 text-sm text-amber-800">
                    {{ session('payment_prompt') }}
                </div>
            @endif
        </header>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm text-sm text-slate-700">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Résumé</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-900">Accéder à l'article complet</h2>
                <p class="mt-3">
                    Réglez le paiement fictif pour débloquer le contenu complet. Une fois le paiement confirmé, vous serez automatiquement redirigé vers la page de l'article.
                </p>
                <ul class="mt-4 space-y-2 text-slate-700">
                    <li>• Paiement unique simulé (pas de débit réel).</li>
                    <li>• Accès immédiat après validation.</li>
                    <li>• Les abonnés actifs ne verront plus cette étape.</li>
                </ul>
            </div>

            @include('blog.partials.payment-card')
        </div>
    </div>
</x-layouts.app>
