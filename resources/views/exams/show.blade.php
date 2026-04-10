@extends('layouts.app')

@section('content')
<div class="relative min-h-screen px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-4xl">
        @php
            $answeredCount = $attempt->answers()->whereNotNull('selected_answer_id')->count();
            $progressPercent = count($questions) > 0 ? ($answeredCount / count($questions)) * 100 : 0;
        @endphp

        <div class="mb-8 overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-cyan-400/20 bg-cyan-400/10 px-4 py-2 text-sm font-semibold text-cyan-100">
                        <span class="h-2 w-2 rounded-full bg-cyan-300"></span>
                        Active exam
                    </div>
                    <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">{{ $exam->title }}</h1>
                    @if($exam->description)
                        <p class="mt-3 max-w-2xl text-slate-300">{{ $exam->description }}</p>
                    @endif
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-center">
                    <div class="text-sm uppercase tracking-[0.2em] text-slate-400">Postęp</div>
                    <div class="mt-2 text-4xl font-black text-white">{{ $answeredCount }}/{{ count($questions) }}</div>
                </div>
            </div>

            <div class="mt-6 h-3 overflow-hidden rounded-full bg-white/10">
                <div class="h-full rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%; background: linear-gradient(90deg, #22d3ee, #0ea5e9, #2563eb);"></div>
            </div>
        </div>

        <form action="{{ route('exams.submit', ['examTest' => $exam->id]) }}" method="POST" class="space-y-6">
            @csrf

            @foreach($questions as $index => $question)
                <div class="surface-card overflow-hidden transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_30px_90px_-28px_rgba(15,23,42,0.5)]">
                    <div class="border-l-4 border-cyan-400 bg-[linear-gradient(135deg,rgba(8,15,31,0.9),rgba(15,23,42,0.85))] p-6">
                        <div class="mb-3 flex items-start justify-between gap-4">
                            <h2 class="flex-1 text-xl font-bold text-white sm:text-2xl">
                                <span class="mr-3 text-cyan-300">{{ $index + 1 }}.</span>
                                {{ $question['text'] }}
                            </h2>
                            <div class="flex gap-2">
                                <span class="inline-flex items-center rounded-full bg-white/10 px-2 py-1 text-xs font-semibold text-cyan-100 ring-1 ring-white/10">
                                    {{ $question['category'] }}
                                </span>
                                @php
                                    $diffColor = match($question['difficulty']) {
                                        'easy' => 'bg-green-100 text-green-800',
                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                        'hard' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold {{ $diffColor }}">
                                    {{ ucfirst($question['difficulty']) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 p-6">
                        <div class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Wybierz odpowiedź</div>

                        @foreach($question['answers'] as $answer)
                            <label class="flex cursor-pointer items-center rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-cyan-300 hover:bg-cyan-50/70">
                                <input
                                    type="radio"
                                    name="question_{{ $question['id'] }}"
                                    value="{{ $answer['id'] }}"
                                    data-question-id="{{ $question['id'] }}"
                                    class="answer-radio h-4 w-4 text-cyan-600"
                                    @checked($question['student_answer'] === $answer['id'])
                                />
                                <span class="ml-3 flex-1 text-slate-800">{{ $answer['text'] }}</span>
                            </label>
                        @endforeach

                        <label class="flex cursor-pointer items-center rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-slate-300 hover:bg-white">
                            <input
                                type="radio"
                                name="question_{{ $question['id'] }}"
                                value=""
                                data-question-id="{{ $question['id'] }}"
                                class="answer-radio h-4 w-4 text-slate-600"
                                @checked(!$question['student_answer'])
                            />
                            <span class="ml-3 text-slate-500">Nie zaznaczam odpowiedzi</span>
                        </label>
                    </div>

                    @if($question['explanation'])
                        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
                            <div class="text-sm">
                                <span class="font-semibold text-slate-900">💡 Podpowiedź:</span>
                                <p class="mt-1 text-slate-600">{{ $question['explanation'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="sticky bottom-0 flex gap-3 rounded-3xl border border-white/10 bg-slate-950/80 p-4 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
                <a href="{{ route('exams.index') }}" class="rounded-2xl border border-white/10 px-6 py-3 font-semibold text-slate-200 transition hover:bg-white/5">
                    ← Powrót
                </a>
                <button
                    type="submit"
                    class="flex-1 rounded-2xl px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:opacity-95"
                    style="background: linear-gradient(90deg, #10b981, #22d3ee);"
                    onclick="return confirm('Czy jesteś pewny? Po wysłaniu nie będziesz mógł zmienić odpowiedzi.')">
                    ✅ Wyślij egzamin
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-save answers via AJAX
    document.querySelectorAll('.answer-radio').forEach(radio => {
        radio.addEventListener('change', async function() {
            const questionId = this.dataset.questionId;
            const answerId = this.value || null;

            try {
                await fetch(`{{ route('exams.submit-answer', ['examTest' => $exam->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        question_id: questionId,
                        answer_id: answerId,
                    }),
                });
            } catch (error) {
                console.error('Error saving answer:', error);
            }
        });
    });
</script>
@endsection
