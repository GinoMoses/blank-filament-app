<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-100">
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-32 top-16 h-72 w-72 rounded-full bg-cyan-500/20 blur-3xl"></div>
            <div class="absolute right-0 top-10 h-96 w-96 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
            <div class="absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-white/30 to-transparent"></div>
        </div>

        <div class="relative flex min-h-screen flex-col">
            <nav class="border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">
                <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <a href="{{ route('exams.index') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-white/5">
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-linear-to-br from-cyan-400 to-blue-500 text-lg text-white shadow-lg shadow-cyan-500/20">📝</span>
                        <span class="flex flex-col leading-tight">
                            <span class="text-sm font-semibold uppercase tracking-[0.28em] text-cyan-200/70">Exam Bank</span>
                            <span class="text-lg font-bold text-white">Bank Pytań Egzaminacyjnych</span>
                        </span>
                    </a>

                    @auth
                        <div class="flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-200 shadow-lg shadow-slate-950/20">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            <span>{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-full bg-white/10 px-4 py-2 font-semibold text-white transition hover:bg-white/15">
                                    Wyloguj
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-5 py-2.5 font-semibold text-cyan-100 transition hover:bg-cyan-400/20 hover:text-white">
                            Zaloguj się
                        </a>
                    @endauth
                </div>
            </nav>

            <main class="relative flex-1">
                @yield('content')
            </main>

            <footer class="border-t border-white/10 bg-slate-950/80">
                <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-between gap-3 text-center text-sm text-slate-400 sm:flex-row sm:text-left">
                        <p>&copy; {{ date('Y') }} Bank Pytań Egzaminacyjnych.</p>
                        <p class="text-slate-500">Built for fast exam prep and clean review.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
