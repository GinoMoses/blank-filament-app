<?php

namespace App\Http\Controllers;

use App\Models\ExamTest;
use App\Models\StudentAnswer;
use App\Models\StudentExamAttempt;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        $exams = ExamTest::with('questions')
            ->get()
            ->map(fn ($exam) => [
                'id' => $exam->id,
                'title' => $exam->title,
                'description' => $exam->description,
                'question_count' => $exam->questions->count(),
                'attempt' => Auth::user()?->examAttempts()
                    ->where('exam_test_id', $exam->id)
                    ->latest()
                    ->first(),
            ]);

        return view('exams.index', ['exams' => $exams]);
    }

    public function show(ExamTest $examTest): View
    {
        $user = Auth::user();

        // Check if student already has a draft attempt
        $attempt = $user->examAttempts()
            ->where('exam_test_id', $examTest->id)
            ->where('status', 'draft')
            ->first();

        // Create new attempt if none exists
        if (! $attempt) {
            $attempt = StudentExamAttempt::create([
                'user_id' => $user->id,
                'exam_test_id' => $examTest->id,
                'started_at' => Carbon::now(),
                'status' => 'draft',
            ]);

            // Create answer records for all questions
            foreach ($examTest->questions as $question) {
                StudentAnswer::create([
                    'student_exam_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                ]);
            }
        }

        $questions = $examTest->questions()
            ->with('answers')
            ->get()
            ->map(fn ($question) => [
                'id' => $question->id,
                'text' => $question->question,
                'explanation' => $question->explanation,
                'difficulty' => is_string($question->difficulty) ? $question->difficulty : $question->difficulty->value,
                'category' => $question->category->name,
                'answers' => $question->answers->map(fn ($answer) => [
                    'id' => $answer->id,
                    'text' => $answer->answer,
                    'is_correct' => $answer->is_correct,
                ])->toArray(),
                'student_answer' => $attempt->answers()
                    ->where('question_id', $question->id)
                    ->first()
                    ?->selected_answer_id,
            ]);

        return view('exams.show', [
            'exam' => $examTest,
            'attempt' => $attempt,
            'questions' => $questions,
        ]);
    }

    public function submitAnswer(Request $request, ExamTest $examTest): Response
    {
        $request->validate([
            'question_id' => ['required', 'integer', Rule::exists('questions', 'id')],
            'answer_id' => ['nullable', 'integer', Rule::exists('question_answers', 'id')],
        ]);

        $user = Auth::user();
        $attempt = $user->examAttempts()
            ->where('exam_test_id', $examTest->id)
            ->where('status', 'draft')
            ->first();

        if (! $attempt) {
            abort(404);
        }

        $question = $examTest->questions()
            ->findOrFail($request->integer('question_id'));

        $selectedAnswerId = $request->filled('answer_id')
            ? $request->integer('answer_id')
            : null;

        if ($selectedAnswerId !== null && ! $question->answers()->whereKey($selectedAnswerId)->exists()) {
            abort(422, 'Selected answer does not belong to this question.');
        }

        $studentAnswer = $attempt->answers()
            ->where('question_id', $question->id)
            ->first();

        if ($studentAnswer) {
            $correctAnswerId = $question->answers()
                ->where('is_correct', true)
                ->value('id');

            $studentAnswer->update([
                'selected_answer_id' => $selectedAnswerId,
                'is_correct' => $selectedAnswerId !== null && $selectedAnswerId === (int) $correctAnswerId,
            ]);
        }

        return response()->noContent();
    }

    public function submit(Request $request, ExamTest $examTest): RedirectResponse
    {
        $user = Auth::user();
        $attempt = $user->examAttempts()
            ->where('exam_test_id', $examTest->id)
            ->where('status', 'draft')
            ->firstOrFail();

        // Calculate and update score
        $score = $attempt->calculateScore();
        $attempt->update([
            'submitted_at' => Carbon::now(),
            'score' => $score,
            'status' => 'submitted',
        ]);

        return redirect()->route('exams.results', ['examTest' => $examTest->id, 'attempt' => $attempt->id]);
    }

    public function results(ExamTest $examTest, StudentExamAttempt $attempt): View
    {
        // Verify user owns this attempt
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        $questions = $examTest->questions()
            ->with('answers')
            ->get()
            ->map(fn ($question) => [
                'id' => $question->id,
                'text' => $question->question,
                'explanation' => $question->explanation,
                'difficulty' => is_string($question->difficulty) ? $question->difficulty : $question->difficulty->value,
                'category' => $question->category->name,
                'answers' => $question->answers->map(fn ($answer) => [
                    'id' => $answer->id,
                    'text' => $answer->answer,
                    'is_correct' => $answer->is_correct,
                ])->toArray(),
                'student_answer' => $attempt->answers()
                    ->where('question_id', $question->id)
                    ->first(),
                'is_correct' => $attempt->answers()
                    ->where('question_id', $question->id)
                    ->first()
                    ?->is_correct ?? false,
            ]);

        return view('exams.results', [
            'exam' => $examTest,
            'attempt' => $attempt,
            'questions' => $questions,
        ]);
    }
}
