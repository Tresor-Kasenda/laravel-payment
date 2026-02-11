<x-layouts.app>
    <section class="space-y-6">
        <header class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="text-3xl font-semibold text-slate-900">Créer un article</h1>
            <p class="text-sm text-slate-600">Renseignez les métadonnées principales puis sauvegardez. Vous pourrez ensuite publier ou archiver depuis l'interface.</p>
        </header>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('admin.posts.store') }}" method="POST" class="grid gap-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Titre
                    <input type="text" name="title" value="{{ old('title') }}" required class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-300 focus:outline-none" />
                    @error('title')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>

                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Slug (optionnel)
                    <input type="text" name="slug" value="{{ old('slug') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-300 focus:outline-none" />
                    @error('slug')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Statut
                    <select name="status" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none">
                        @foreach ($statusOptions as $option)
                            <option value="{{ $option->value }}" {{ old('status', 'draft') === $option->value ? 'selected' : '' }}>{{ ucfirst($option->value) }}</option>
                        @endforeach
                    </select>
                    @error('status')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>

                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Lecture (minutes)
                    <input type="number" min="1" max="240" name="reading_time_minutes" value="{{ old('reading_time_minutes', 5) }}" required class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none" />
                    @error('reading_time_minutes')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>

                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Date de publication
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none" />
                    @error('published_at')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>
            </div>

            <label class="flex flex-col gap-2 text-sm text-slate-700">
                Extrait
                <textarea name="excerpt" rows="2" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none" placeholder="Décrivez l’article en une ou deux phrases.">{{ old('excerpt') }}</textarea>
                @error('excerpt')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <label class="flex flex-col gap-2 text-sm text-slate-700">
                Contenu
                <textarea name="content" rows="10" required class="rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none" placeholder="Utilisez Markdown ou HTML ici.">{{ old('content') }}</textarea>
                @error('content')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <div class="grid gap-4 md:grid-cols-3">
                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Image mise en avant (URL)
                    <input type="url" name="featured_image" value="{{ old('featured_image') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none" />
                    @error('featured_image')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>

                <label class="flex flex-col gap-2 text-sm text-slate-700">
                    Articles réservés ?
                    @php $visibility = old('visible_to_subscribers_only', '0'); @endphp
                    <select name="visible_to_subscribers_only" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-300 focus:outline-none">
                        <option value="0" {{ $visibility === '0' ? 'selected' : '' }}>Non</option>
                        <option value="1" {{ $visibility === '1' ? 'selected' : '' }}>Oui</option>
                    </select>
                    @error('visible_to_subscribers_only')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>
            </div>

            <button type="submit" class="rounded-3xl border border-emerald-200 bg-emerald-50 px-6 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-100">
                Créer l’article
            </button>
        </form>
    </section>
</x-layouts.app>
