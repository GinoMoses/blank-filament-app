<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie - Bank Pytań Egzaminacyjnych</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-100">
    <div class="relative min-h-screen overflow-hidden px-4 py-6 sm:px-6 lg:px-8">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-1/2 top-0 h-72 w-72 -translate-x-1/2 rounded-full bg-cyan-400/20 blur-3xl"></div>
            <div class="absolute -bottom-16 right-10 h-80 w-80 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid min-h-[calc(100vh-3rem)] max-w-6xl items-center gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <section class="glass-panel surface-card relative overflow-hidden p-8 sm:p-10 lg:p-12">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.18),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(244,114,182,0.12),transparent_28%)]"></div>
                <div class="relative">
                    <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-cyan-400/20 bg-cyan-400/10 px-4 py-2 text-sm font-semibold text-cyan-100">
                        <span class="h-2 w-2 rounded-full bg-cyan-300"></span>
                        Student access
                    </div>

                    <h1 class="max-w-xl text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Bank pytań, który wygląda jak produkt, nie szablon.
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-300">
                        Zaloguj się, przejdź do egzaminów i wróć do wyników bez zbędnego tarcia. Szybki start, czytelny układ i zero chaosu.
                    </p>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="text-2xl font-bold text-white">225+</div>
                            <div class="mt-1 text-sm text-slate-300">Pytania w banku</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="text-2xl font-bold text-white">3</div>
                            <div class="mt-1 text-sm text-slate-300">Gotowe testy</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="text-2xl font-bold text-white">Auto</div>
                            <div class="mt-1 text-sm text-slate-300">Zapis odpowiedzi</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="surface-card p-6 shadow-2xl shadow-slate-950/40 sm:p-8">
                <div class="mb-8 text-center">
                    <div class="mx-auto mb-4 grid h-16 w-16 place-items-center rounded-2xl text-2xl shadow-lg shadow-cyan-500/20" style="background: linear-gradient(135deg, #22d3ee, #3b82f6);">
                        📝
                    </div>
                    <h2 class="text-3xl font-bold text-slate-950">Zaloguj się</h2>
                    <p class="mt-2 text-slate-600">Bank Pytań Egzaminacyjnych</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-2xl bg-white px-4 py-3 text-slate-900 shadow-sm ring-1 ring-slate-200 transition placeholder:text-slate-400 focus:ring-4 focus:ring-cyan-500/15"
                            placeholder="student@test.com"
                            required
                            autofocus
                        />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Hasło</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/15"
                            placeholder="••••••••"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        class="group inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-950 px-4 py-3.5 text-base font-semibold text-white shadow-lg shadow-slate-950/20 transition hover:-translate-y-0.5 hover:bg-slate-900"
                    >
                        Zaloguj się
                        <span class="transition group-hover:translate-x-0.5">→</span>
                    </button>
                </form>

                <div class="mt-6 rounded-2xl border border-cyan-200 bg-cyan-50 p-4 text-slate-800">
                    <p class="text-sm font-semibold text-cyan-900">Dane testowe</p>
                    <div class="mt-3 grid gap-2 text-sm">
                        <div class="flex items-center justify-between gap-4 rounded-xl bg-white px-3 py-2 shadow-sm">
                            <span class="text-slate-500">Email</span>
                            <code class="font-semibold text-slate-900">student@test.com</code>
                        </div>
                        <div class="flex items-center justify-between gap-4 rounded-xl bg-white px-3 py-2 shadow-sm">
                            <span class="text-slate-500">Hasło</span>
                            <code class="font-semibold text-slate-900">password</code>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
