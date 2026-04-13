<?php

use App\Filament\Resources\ExamTests\Pages\ListExamTests;
use App\Models\ExamTest;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    actingAs($this->admin);
});

it('can list exam tests', function () {
    $examTest = ExamTest::factory()->create();

    livewire(ListExamTests::class)
        ->assertCanSeeTableRecords([$examTest]);
});

it('displays question count for exam tests', function () {
    $category = QuestionCategory::factory()->create();
    $examTest = ExamTest::factory()->create();
    $questions = Question::factory()->count(5)->create(['question_category_id' => $category->id]);
    $examTest->questions()->attach($questions->pluck('id'));

    livewire(ListExamTests::class)
        ->assertCanSeeTableRecords([$examTest]);
});

it('shows generation type badge', function () {
    $manualTest = ExamTest::factory()->create(['generation_type' => 'manual']);
    $randomTest = ExamTest::factory()->create(['generation_type' => 'random']);

    livewire(ListExamTests::class)
        ->assertCanSeeTableRecords([$manualTest, $randomTest]);
});

it('shows generated status badge', function () {
    $draftTest = ExamTest::factory()->create(['generated_at' => null]);
    $generatedTest = ExamTest::factory()->create(['generated_at' => now()]);

    livewire(ListExamTests::class)
        ->assertCanSeeTableRecords([$draftTest, $generatedTest]);
});
