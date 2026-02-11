<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Blog') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 text-slate-900">
    <div class="flex min-h-screen flex-col bg-gradient-to-b from-white via-gray-50 to-white">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-5">
                <div>
                    <a href="{{ route('home') }}" class="text-lg font-semibold tracking-wide text-slate-900">
                        {{ config('app.name', 'Blog') }}
                    </a>
                    <p class="text-xs text-slate-500">Articles premium, abonnements mensuels sécurisés.</p>
                </div>
                <div class="flex items-center gap-4 text-sm text-slate-600">
                    <a href="{{ route('subscription.dashboard') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-slate-800 transition hover:border-slate-300 hover:shadow-sm">
                        Abonnement
                    </a>

                    @guest
                        <a href="{{ route('admin.login') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-slate-800 transition hover:border-slate-300 hover:shadow-sm">
                            Connexion admin
                        </a>
                    @endguest

                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.posts.create') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                                Publier
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}" class="inline-flex">
                                @csrf
                                <button type="submit" class="rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-rose-700 transition hover:border-rose-300 hover:bg-rose-100">
                                    Déconnexion
                                </button>
                            </form>
                        @endif

                        <span class="text-slate-700">{{ auth()->user()->name }}</span>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-1">
            <div class="mx-auto max-w-6xl px-4 py-10">
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>
