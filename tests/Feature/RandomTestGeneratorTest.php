<?php

use App\DifficultyLevel;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Services\RandomTestGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('generates random test with correct question count', function () {
    $category = QuestionCategory::factory()->create();
    Question::factory()->count(20)->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Easy,
    ]);

    $service = new RandomTestGeneratorService;
    $examTest = $service->generateRandomTest(
        title: 'Test Exam',
        description: 'A random test',
        numberOfQuestions: 10,
    );

    expect($examTest->questions()->count())->toBe(10);
});

it('filters by category when generating random test', function () {
    $category1 = QuestionCategory::factory()->create(['name' => 'Math']);
    $category2 = QuestionCategory::factory()->create(['name' => 'Science']);

    Question::factory()->count(10)->create(['question_category_id' => $category1->id]);
    Question::factory()->count(5)->create(['question_category_id' => $category2->id]);

    $service = new RandomTestGeneratorService;
    $examTest = $service->generateRandomTest(
        title: 'Math Test',
        description: 'Only math questions',
        numberOfQuestions: 10,
        categoryIds: [$category1->id],
    );

    $questionCategories = $examTest->questions->pluck('question_category_id')->unique();
    expect($questionCategories->count())->toBe(1)
        ->and($questionCategories->first())->toBe($category1->id);
});

it('filters by difficulty when generating random test', function () {
    $category = QuestionCategory::factory()->create();
    Question::factory()->count(5)->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Easy,
    ]);
    Question::factory()->count(10)->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Hard,
    ]);

    $service = new RandomTestGeneratorService;
    $examTest = $service->generateRandomTest(
        title: 'Hard Test',
        description: 'Only hard questions',
        numberOfQuestions: 5,
        difficulties: [DifficultyLevel::Hard->value],
    );

    $allHard = $examTest->questions->every(fn ($q) => $q->difficulty === DifficultyLevel::Hard);
    expect($allHard)->toBeTrue();
});

it('throws exception when no questions match criteria', function () {
    $service = new RandomTestGeneratorService;

    expect(fn () => $service->generateRandomTest(
        title: 'Empty Test',
        description: 'No questions',
        numberOfQuestions: 10,
        categoryIds: [9999],
    ))->toThrow(\Exception::class, 'No questions available');
});

it('get random questions returns collection', function () {
    $category = QuestionCategory::factory()->create();
    Question::factory()->count(15)->create(['question_category_id' => $category->id]);

    $service = new RandomTestGeneratorService;
    $questions = $service->getRandomQuestions(limit: 5);

    expect($questions->count())->toBe(5);
});
