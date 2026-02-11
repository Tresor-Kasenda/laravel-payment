<x-layouts.app>
    <section class="mx-auto max-w-md space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <header class="space-y-1 text-center">
            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Zone administrateur</p>
            <h1 class="text-2xl font-semibold text-slate-900">Connexion</h1>
            <p class="text-sm text-slate-600">Seuls les administrateurs peuvent publier des articles ou modifier le contenu premium.</p>
        </header>

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf

            <label class="flex flex-col gap-1 text-sm text-slate-700">
                Email
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:outline-none" />
                @error('email')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <label class="flex flex-col gap-1 text-sm text-slate-700">
                Mot de passe
                <input type="password" name="password" required class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-400 focus:outline-none" />
                @error('password')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <label class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.4em] text-slate-500">
                <input type="checkbox" name="remember" class="text-emerald-500 focus:ring-emerald-400" />
                Se souvenir de moi
            </label>

            <button type="submit" class="w-full rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-100">
                Se connecter
            </button>
        </form>
    </section>
</x-layouts.app>
