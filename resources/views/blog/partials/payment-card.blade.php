<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-semibold text-slate-900">Paiement</h2>

    @if(session('payment_status'))
        <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('payment_status') }}
        </div>
    @endif

    @auth
        <form action="{{ route('blog.payment', $blogPost) }}" method="POST" class="mt-4 space-y-4">
            @csrf

            <label class="text-sm text-slate-700">
                Nom complet
                <input type="text" name="full_name" value="{{ old('full_name') }}" required class="mt-1 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 focus:border-emerald-400 focus:outline-none" />
                @error('full_name')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <div class="grid gap-4 md:grid-cols-2">
                <label class="text-sm text-slate-700">
                    Code pays
                    <select name="country_code" class="mt-1 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900">
                        @foreach($countryCodes as $code)
                            <option value="{{ $code['value'] }}" {{ old('country_code') === $code['value'] ? 'selected' : '' }}>{{ $code['label'] }} ({{ $code['value'] }})</option>
                        @endforeach
                    </select>
                    @error('country_code')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>

                <label class="text-sm text-slate-700">
                    Téléphone
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required class="mt-1 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 focus:border-emerald-400 focus:outline-none" />
                    @error('phone_number')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
                </label>
            </div>

            <label class="text-sm text-slate-700">
                Plan
                <select name="plan_name" class="mt-1 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900">
                    @foreach($planOptions as $option)
                        <option value="{{ $option['value'] }}" data-amount="{{ $option['amount'] }}" {{ old('plan_name') === $option['value'] ? 'selected' : '' }}>
                            {{ $option['label'] }} — {{ number_format($option['amount'], 2) }} CDF
                        </option>
                    @endforeach
                </select>
                @error('plan_name')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <label class="text-sm text-slate-700">
                Montant (CDF)
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $planOptions[0]['amount'] ?? 5000) }}" required class="mt-1 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 focus:border-emerald-400 focus:outline-none" />
                @error('amount')<span class="text-xs text-rose-400">{{ $message }}</span>@enderror
            </label>

            <button type="submit" class="w-full rounded-3xl mt-4 border border-emerald-200 bg-emerald-50 px-6 py-3 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-100">
                Simuler le paiement
            </button>
        </form>
    @else
        <p class="mt-4 text-sm text-slate-700">
            Connectez-vous pour enregistrer un paiement et accéder aux articles réservés.
        </p>
    @endauth
</div>
