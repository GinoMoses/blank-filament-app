<?php

use App\DifficultyLevel;
use App\Filament\Resources\Questions\Pages\ListQuestions;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create();
    actingAs($this->admin);
});

it('can list questions', function () {
    $category = QuestionCategory::factory()->create();
    $question = Question::factory()->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Easy,
    ]);
    QuestionAnswer::factory()->count(4)->create([
        'question_id' => $question->id,
    ]);

    livewire(ListQuestions::class)
        ->assertCanSeeTableRecords([$question]);
});

it('can filter questions by category', function () {
    $category1 = QuestionCategory::factory()->create();
    $category2 = QuestionCategory::factory()->create();

    $question1 = Question::factory()->create(['question_category_id' => $category1->id]);
    $question2 = Question::factory()->create(['question_category_id' => $category2->id]);

    livewire(ListQuestions::class)
        ->assertCanSeeTableRecords([$question1, $question2])
        ->filterTable('question_category_id', $category1->id)
        ->assertCanSeeTableRecords([$question1])
        ->assertCanNotSeeTableRecords([$question2]);
});

it('can filter questions by difficulty', function () {
    $questionEasy = Question::factory()->create(['difficulty' => DifficultyLevel::Easy]);
    $questionHard = Question::factory()->create(['difficulty' => DifficultyLevel::Hard]);

    livewire(ListQuestions::class)
        ->assertCanSeeTableRecords([$questionEasy, $questionHard])
        ->filterTable('difficulty', 'easy')
        ->assertCanSeeTableRecords([$questionEasy])
        ->assertCanNotSeeTableRecords([$questionHard]);
});

it('can search questions', function () {
    $question1 = Question::factory()->create(['question' => 'What is PHP?']);
    $question2 = Question::factory()->create(['question' => 'What is Laravel?']);

    livewire(ListQuestions::class)
        ->assertCanSeeTableRecords([$question1, $question2])
        ->searchTable('PHP')
        ->assertCanSeeTableRecords([$question1])
        ->assertCanNotSeeTableRecords([$question2]);
});

it('displays difficulty badges with correct colors', function () {
    $category = QuestionCategory::factory()->create();
    $questionEasy = Question::factory()->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Easy,
    ]);
    $questionHard = Question::factory()->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Hard,
    ]);

    livewire(ListQuestions::class)
        ->assertCanSeeTableRecords([$questionEasy, $questionHard]);
});
