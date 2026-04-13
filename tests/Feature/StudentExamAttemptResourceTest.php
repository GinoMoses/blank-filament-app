<?php

use App\Filament\Resources\StudentExamAttempts\Pages\ListStudentExamAttempts;
use App\Models\ExamTest;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCategory;
use App\Models\StudentExamAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    actingAs($this->admin);
});

it('can list student exam attempts', function () {
    $student = User::factory()->create();
    $category = QuestionCategory::factory()->create();
    $examTest = ExamTest::factory()->create();
    $question = Question::factory()->create(['question_category_id' => $category->id]);
    QuestionAnswer::factory()->count(4)->create(['question_id' => $question->id]);
    $examTest->questions()->attach([$question->id]);

    $attempt = StudentExamAttempt::factory()->create([
        'user_id' => $student->id,
        'exam_test_id' => $examTest->id,
    ]);

    livewire(ListStudentExamAttempts::class)
        ->assertCanSeeTableRecords([$attempt]);
});

it('displays attempt status correctly', function () {
    $student = User::factory()->create();
    $examTest = ExamTest::factory()->create();

    $draftAttempt = StudentExamAttempt::factory()->create([
        'user_id' => $student->id,
        'exam_test_id' => $examTest->id,
        'status' => 'draft',
    ]);

    $submittedAttempt = StudentExamAttempt::factory()->create([
        'user_id' => $student->id,
        'exam_test_id' => $examTest->id,
        'status' => 'submitted',
        'score' => 85,
    ]);

    livewire(ListStudentExamAttempts::class)
        ->assertCanSeeTableRecords([$draftAttempt, $submittedAttempt]);
});

it('can filter by status', function () {
    $student = User::factory()->create();
    $examTest = ExamTest::factory()->create();

    $draftAttempt = StudentExamAttempt::factory()->create([
        'user_id' => $student->id,
        'exam_test_id' => $examTest->id,
        'status' => 'draft',
    ]);

    $submittedAttempt = StudentExamAttempt::factory()->create([
        'user_id' => $student->id,
        'exam_test_id' => $examTest->id,
        'status' => 'submitted',
    ]);

    livewire(ListStudentExamAttempts::class)
        ->assertCanSeeTableRecords([$draftAttempt, $submittedAttempt])
        ->filterTable('status', 'submitted')
        ->assertCanSeeTableRecords([$submittedAttempt])
        ->assertCanNotSeeTableRecords([$draftAttempt]);
});
