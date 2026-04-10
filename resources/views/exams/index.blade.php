@extends('layouts.app')

@section('content')
<div class="relative min-h-screen px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl">
        <div class="mb-10 overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-xl sm:p-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-cyan-400/20 bg-cyan-400/10 px-4 py-2 text-sm font-semibold text-cyan-100">
                        <span class="h-2 w-2 rounded-full bg-cyan-300"></span>
                        Student dashboard
                    </div>
                    <h1 class="text-4xl font-black tracking-tight text-white sm:text-5xl">
                        Wybierz egzamin i jedź dalej.
                    </h1>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-300">
                        Przejrzysty widok dostępnych testów, status postępu i szybki powrót do rozpoczętych prób.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center sm:min-w-[320px]">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-2xl font-bold text-white">{{ $exams->count() }}</div>
                        <div class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">Egzaminy</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-2xl font-bold text-white">225+</div>
                        <div class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">Pytań</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-2xl font-bold text-white">1</div>
                        <div class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">Klik</div>
                    </div>
                </div>
            </div>
        </div>

        @if($exams->isEmpty())
            <div class="surface-card p-8 text-center text-slate-700">
                <p class="text-lg font-semibold text-slate-900">Brak dostępnych egzaminów.</p>
                <p class="mt-2 text-sm text-slate-500">Wróć później albo poproś nauczyciela o dodanie testów.</p>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-2">
                @foreach($exams as $exam)
                    <div class="surface-card overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-[0_32px_90px_-24px_rgba(15,23,42,0.5)]">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-slate-950">{{ $exam['title'] }}</h2>
                                    @if($exam['description'])
                                        <p class="mt-3 text-slate-600">{{ $exam['description'] }}</p>
                                    @endif
                                </div>
                                <span class="inline-flex items-center rounded-full bg-cyan-50 px-3 py-1 text-sm font-semibold text-cyan-800 ring-1 ring-cyan-200">
                                    {{ $exam['question_count'] }} pytań
                                </span>
                            </div>

                            <div class="mt-6 flex flex-col gap-4 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">
                                @if($exam['attempt'])
                                    <div class="text-sm">
                                        @if($exam['attempt']->status === 'draft')
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">
                                                ⏱️ W trakcie ({{ $exam['attempt']->started_at?->diffForHumans() }})
                                            </span>
                                        @elseif($exam['attempt']->status === 'submitted')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800">
                                                ✅ Ukończono - {{ $exam['attempt']->score }}%
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-slate-500">Nowy egzamin</p>
                                @endif

                                <a href="{{ route('exams.show', ['examTest' => $exam['id']]) }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-900">
                                    @if($exam['attempt'] && $exam['attempt']->status === 'draft')
                                        Kontynuuj →
                                    @else
                                        Rozwiąż →
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
