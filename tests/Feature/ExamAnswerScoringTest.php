<?php

use App\Models\ExamTest;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\StudentExamAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('correct answer is recognized and results in full score', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $category = QuestionCategory::factory()->create();

    $question = Question::query()->create([
        'question_category_id' => $category->id,
        'question' => '2 + 2 = ? ',
        'difficulty' => 'easy',
        'explanation' => null,
        'created_by' => $user->id,
    ]);

    $correctAnswer = $question->answers()->create([
        'answer' => '4',
        'is_correct' => true,
    ]);

    $question->answers()->create([
        'answer' => '5',
        'is_correct' => false,
    ]);

    $exam = ExamTest::query()->create([
        'title' => 'Math quick test',
        'description' => null,
        'number_of_questions' => 1,
        'created_by' => $user->id,
        'generated_at' => now(),
    ]);

    $exam->questions()->attach($question->id, ['order' => 1]);

    $this->actingAs($user)
        ->get(route('exams.show', ['examTest' => $exam->id]))
        ->assertSuccessful();

    $this->actingAs($user)
        ->postJson(route('exams.submit-answer', ['examTest' => $exam->id]), [
            'question_id' => $question->id,
            'answer_id' => (string) $correctAnswer->id,
        ])
        ->assertNoContent();

    $this->assertDatabaseHas('student_answers', [
        'question_id' => $question->id,
        'selected_answer_id' => $correctAnswer->id,
        'is_correct' => true,
    ]);

    $this->actingAs($user)
        ->post(route('exams.submit', ['examTest' => $exam->id]))
        ->assertRedirect();

    $attempt = StudentExamAttempt::query()->firstOrFail();

    expect($attempt->score)->toBe(100)
        ->and($attempt->status)->toBe('submitted');
});
