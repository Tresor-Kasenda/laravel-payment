<x-layouts.app>
    <div class="space-y-8">
        <article class="space-y-4 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <header class="space-y-3">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $blogPost->status->value === 'published' ? 'Publié' : ucfirst($blogPost->status->value) }}</p>
                <h1 class="text-4xl font-semibold text-slate-900">{{ $blogPost->title }}</h1>
                <div class="flex flex-wrap gap-3 text-xs uppercase tracking-[0.3em] text-slate-500">
                    <span>Par {{ $blogPost->author->name }}</span>
                    <span>{{ $blogPost->published_at?->format('d/m/Y') ?? 'À venir' }}</span>
                    <span>{{ $blogPost->reading_time_minutes }} min de lecture</span>
                </div>
            </header>

            <p class="text-sm text-slate-600">{{ $blogPost->excerpt }}</p>

            <div class="prose max-w-none text-slate-800">
                {!! nl2br(e($blogPost->content)) !!}
            </div>
        </article>

        <section class="grid gap-6 lg:grid-cols-2">
            @include('blog.partials.payment-card')

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm text-sm text-slate-700">
                <h2 class="text-lg font-semibold text-slate-900">Besoin d’un abonnement ?</h2>
                <p class="mt-2">Les articles marqués « abonnés » ne sont disponibles qu’aux membres actifs. Utilisez le formulaire pour enregistrer un paiement fictif (adapter à votre passerelle).</p>
            </div>
        </section>
    </div>
</x-layouts.app>
