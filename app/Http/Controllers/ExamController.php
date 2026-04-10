<?php

namespace App\Http\Controllers;

use App\Models\ExamTest;
use App\Models\StudentAnswer;
use App\Models\StudentExamAttempt;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
                'attempt' => auth()->user()?->examAttempts()
                    ->where('exam_test_id', $exam->id)
                    ->latest()
                    ->first(),
            ]);

        return view('exams.index', ['exams' => $exams]);
    }

    public function show(ExamTest $examTest): View
    {
        $user = auth()->user();

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
                'text' => $question->text,
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

    public function submitAnswer(Request $request, ExamTest $examTest)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'nullable|exists:question_answers,id',
        ]);

        $user = auth()->user();
        $attempt = $user->examAttempts()
            ->where('exam_test_id', $examTest->id)
            ->where('status', 'draft')
            ->first();

        if (! $attempt) {
            abort(404);
        }

        $studentAnswer = $attempt->answers()
            ->where('question_id', $request->question_id)
            ->first();

        if ($studentAnswer) {
            // Update selected answer and correctness
            $correctAnswer = $examTest->questions()
                ->find($request->question_id)
                ->answers()
                ->where('is_correct', true)
                ->first();

            $studentAnswer->update([
                'selected_answer_id' => $request->answer_id,
                'is_correct' => $request->answer_id === $correctAnswer?->id,
            ]);
        }
    }

    public function submit(Request $request, ExamTest $examTest): RedirectResponse
    {
        $user = auth()->user();
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
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        $questions = $examTest->questions()
            ->with('answers')
            ->get()
            ->map(fn ($question) => [
                'id' => $question->id,
                'text' => $question->text,
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
