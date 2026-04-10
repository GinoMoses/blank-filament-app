@extends('layouts.app')

@section('content')
<div class="relative min-h-screen px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-4xl">
        <div class="mb-8 overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
            <div class="text-center">
                <div class="mx-auto mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-4 py-2 text-sm font-semibold text-emerald-100">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    Completed attempt
                </div>
                <h1 class="text-4xl font-black tracking-tight text-white sm:text-5xl">{{ $exam->title }}</h1>
                <p class="mt-3 text-slate-300">Twoje wyniki i pełny przegląd odpowiedzi</p>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-cyan-400/15 bg-cyan-400/10 p-6 text-center">
                    <div class="text-5xl font-black text-white">{{ $attempt->score }}%</div>
                    <p class="mt-2 text-sm uppercase tracking-[0.2em] text-cyan-100/70">Wynik końcowy</p>
                </div>
                <div class="rounded-3xl border border-emerald-400/15 bg-emerald-400/10 p-6 text-center">
                    <div class="text-5xl font-black text-white">{{ $questions->filter(fn($q) => $q['is_correct'])->count() }}</div>
                    <p class="mt-2 text-sm uppercase tracking-[0.2em] text-emerald-100/70">Poprawne</p>
                </div>
                <div class="rounded-3xl border border-rose-400/15 bg-rose-400/10 p-6 text-center">
                    <div class="text-5xl font-black text-white">{{ $questions->filter(fn($q) => !$q['is_correct'])->count() }}</div>
                    <p class="mt-2 text-sm uppercase tracking-[0.2em] text-rose-100/70">Błędne</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                @php
                    $grade = match(true) {
                        $attempt->score >= 90 => ['5', 'Celujący', 'bg-green-100 text-green-800'],
                        $attempt->score >= 80 => ['4', 'Bardzo dobry', 'bg-blue-100 text-blue-800'],
                        $attempt->score >= 70 => ['3', 'Dobry', 'bg-yellow-100 text-yellow-800'],
                        $attempt->score >= 60 => ['2', 'Dostateczny', 'bg-orange-100 text-orange-800'],
                        $attempt->score >= 50 => ['1', 'Niedostateczny', 'bg-red-100 text-red-800'],
                        default => ['1', 'Niedostateczny', 'bg-red-100 text-red-800'],
                    };
                @endphp
                <span class="inline-flex items-center rounded-full px-6 py-3 text-lg font-bold {{ $grade[2] }}">
                    Ocena: {{ $grade[0] }} ({{ $grade[1] }})
                </span>
            </div>

            <div class="mt-6 border-t border-white/10 pt-6">
                <p class="text-center text-sm text-slate-400">
                    <strong>Rozpoczęto:</strong> {{ $attempt->started_at?->format('d.m.Y H:i') }}<br>
                    <strong>Ukończono:</strong> {{ $attempt->submitted_at?->format('d.m.Y H:i') }}
                </p>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="mb-6 text-2xl font-black text-white">Przegląd odpowiedzi</h2>

            <div class="space-y-6">
                @foreach($questions as $index => $question)
                    @php
                        $isCorrect = $question['is_correct'];
                        $bgColor = $isCorrect ? 'bg-green-50' : 'bg-red-50';
                        $borderColor = $isCorrect ? 'border-green-200' : 'border-red-200';
                        $headerColor = $isCorrect ? 'bg-green-100' : 'bg-red-100';
                    @endphp

                    <div class="surface-card overflow-hidden border-l-4 {{ $borderColor }}">
                        <div class="{{ $headerColor }} p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="flex-1 font-semibold text-slate-900">
                                    <span class="mr-2">{{ $index + 1 }}.</span>
                                    {{ $question['text'] }}
                                </h3>
                                @if($isCorrect)
                                    <span class="ml-4 font-bold text-green-700">✅ Poprawnie</span>
                                @else
                                    <span class="ml-4 font-bold text-red-700">❌ Błędnie</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-6">
                                <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Twoja odpowiedź</p>
                                @if($question['student_answer'])
                                    <div class="{{ $isCorrect ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500' }} rounded p-4">
                                        <p class="text-slate-800">
                                            {{ $question['student_answer']->selectedAnswer->answer ?? 'Brak odpowiedzi' }}
                                        </p>
                                    </div>
                                @else
                                    <div class="rounded border-l-4 border-slate-400 bg-slate-50 p-4">
                                        <p class="italic text-slate-500">Nie zaznaczono żadnej odpowiedzi</p>
                                    </div>
                                @endif
                            </div>

                            @if(!$isCorrect)
                                <div class="mb-6">
                                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Prawidłowa odpowiedź</p>
                                    <div class="rounded border-l-4 border-green-500 bg-green-50 p-4">
                                        <p class="text-slate-800">
                                            {{ collect($question['answers'])->firstWhere('is_correct', true)['text'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if($question['explanation'])
                                <div class="rounded border-l-4 border-cyan-400 bg-cyan-50 p-4">
                                    <p class="mb-2 text-sm font-semibold text-cyan-900">💡 Wyjaśnienie</p>
                                    <p class="text-cyan-950">{{ $question['explanation'] }}</p>
                                </div>
                            @endif

                            <div class="mt-4 flex gap-2">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs text-slate-700">
                                    {{ $question['category'] }}
                                </span>
                                @php
                                    $diffColor = match($question['difficulty']) {
                                        'easy' => 'bg-green-100 text-green-700',
                                        'medium' => 'bg-yellow-100 text-yellow-700',
                                        'hard' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="rounded px-2 py-1 text-xs {{ $diffColor }}">
                                    {{ ucfirst($question['difficulty']) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="sticky bottom-0 flex gap-4 rounded-3xl border border-white/10 bg-slate-950/85 p-4 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
            <a href="{{ route('exams.index') }}" class="flex-1 rounded-2xl px-6 py-3 text-center font-semibold text-white transition hover:opacity-95" style="background: linear-gradient(90deg, #06b6d4, #2563eb);">
                ← Powrót do egzaminów
            </a>
            @if($attempt->examTest->questions->count() > 0)
                <a href="{{ route('exams.show', ['examTest' => $exam->id]) }}" class="flex-1 rounded-2xl border border-white/10 px-6 py-3 text-center font-semibold text-slate-200 transition hover:bg-white/5">
                    🔄 Spróbuj ponownie
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
