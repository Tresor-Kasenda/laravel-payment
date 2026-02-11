<x-layouts.app>
    <section class="space-y-8">
        <header class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Magazine mensuel</p>
            <h1 class="text-3xl font-semibold text-slate-900">La newsletter créative</h1>
            <p class="mt-3 text-sm text-slate-600">
                Chaque article peut être librement consulté ou réservé aux abonnés. Vous avez la main
                pour afficher les aperçus et déclencher les paiements sans Livewire.
            </p>
        </header>

        <div class="grid gap-6 lg:grid-cols-3">
            @forelse ($posts as $post)
                <a href="{{ route($post->visible_to_subscribers_only ? 'blog.payment.form' : 'blog.show', $post) }}" class="flex flex-col justify-between gap-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <header class="space-y-2">
                        <div class="flex items-center justify-between text-xs uppercase tracking-[0.3em] text-slate-500">
                            <span class="text-slate-600">{{ ucfirst($post->status->value) }}</span>
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[0.65rem] text-slate-700">
                                {{ $post->visible_to_subscribers_only ? 'Abonnés' : 'Libre' }}
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $post->title }}</h2>
                        <p class="text-sm leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
                    </header>

                    <footer class="flex items-center justify-between text-[0.75rem] text-slate-500">
                        <span>Par {{ $post->author->name }}</span>
                        <span>{{ $post->published_at?->format('d/m/Y') ?? 'À venir' }}</span>
                    </footer>
                </a>
            @empty
                <p class="rounded-3xl border border-slate-200 bg-white p-6 text-slate-600 shadow-sm">Aucun article publié pour l’instant.</p>
            @endforelse
        </div>

        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
    </section>
</x-layouts.app>
