<div class="grid gap-8">
    <section class="rounded-3xl border border-slate-800 bg-slate-950/60 p-6 shadow-inner shadow-slate-900/60">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Magazine mensuel</p>
                <h1 class="text-3xl font-semibold text-white">Restez informé et soutenez la création</h1>
                <p class="max-w-xl text-sm text-slate-300">
                    Créez et partagez des articles exclusifs, puis protégez-les derrière un abonnement mensuel.
                    Les lecteurs voient immédiatement ce qui est ouvert et ce qui nécessite un abonnement.
                </p>
            </div>
            <div class="text-sm text-slate-300">
                <p>Articles affichés : <strong class="text-white">{{ $posts->count() }}</strong></p>
                <p>Articles abonnés : <strong class="text-white">{{ $subscriberPostsCount }}</strong></p>
            </div>
        </div>
        <div class="mt-4 flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.2em]">
            <button wire:click="refreshPosts" wire:loading.attr="disabled" class="rounded-full border border-emerald-500 px-4 py-2 font-bold text-emerald-300 transition hover:bg-emerald-500/10">
                Actualiser
            </button>
            <span wire:loading wire:target="refreshPosts" class="text-slate-500">Rechargement...</span>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <article wire:key="post-{{ $post->id }}" class="flex h-full flex-col justify-between gap-5 rounded-3xl border border-slate-800 bg-white/5 p-6 shadow-xl shadow-slate-900/40">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between gap-2 text-xs uppercase tracking-[0.3em] text-slate-400">
                        <span>{{ ucfirst($post->status->value) }}</span>
                        <span class="rounded-full border border-slate-700 px-3 py-1 text-[0.65rem] tracking-[0.5em]">
                            {{ $post->visible_to_subscribers_only ? 'Abonnés' : 'Libre' }}
                        </span>
                    </div>
                    <h2 class="text-xl font-semibold text-white">{{ $post->title }}</h2>
                    <p class="text-sm leading-relaxed text-slate-300">{{ $post->excerpt }}</p>
                </div>
                <footer class="flex flex-wrap items-center justify-between gap-2 text-[0.75rem] text-slate-500">
                    <span>Par {{ $post->author->name }}</span>
                    <span>{{ $post->published_at?->format('d/m/Y') ?? 'À venir' }}</span>
                    <span>{{ $post->reading_time_minutes }} min de lecture</span>
                </footer>
            </article>
        @empty
            <p class="rounded-3xl border border-slate-800 bg-white/5 p-6 text-slate-300">
                Aucun article publié pour le moment. Créez un premier billet et il apparaîtra ici en quelques secondes.
            </p>
        @endforelse
    </section>

    @auth
        <section class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/70 p-6 text-sm text-slate-300">
            <div class="flex items-center justify-between">
                <p>
                    Vous avez {{ $userHasSubscription ? 'un abonnement actif' : 'pas encore d’abonnement' }}.
                </p>
                <a href="{{ route('subscription.dashboard') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-400">
                    Gérer mon abonnement
                </a>
            </div>
            <p class="mt-2 text-xs text-slate-500">
                Les articles marqués « abonnés » deviennent disponibles dès que votre abonnement est actif.
            </p>
        </section>
    @endauth
</div>
