<?php

use App\DifficultyLevel;
use App\Models\ExamTest;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCategory;
use App\Services\ExamPdfExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

uses(RefreshDatabase::class);

it('generates exam pdf without answers', function () {
    $category = QuestionCategory::factory()->create();
    $examTest = ExamTest::factory()->create();
    $question = Question::factory()->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Easy,
    ]);
    QuestionAnswer::factory()->count(4)->create([
        'question_id' => $question->id,
    ]);
    $examTest->questions()->attach([$question->id]);

    $service = new ExamPdfExportService;
    $response = $service->generateExamPdf($examTest, includeAnswers: false);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers->get('Content-Type'))->toContain('pdf');
});

it('generates exam pdf with answers', function () {
    $category = QuestionCategory::factory()->create();
    $examTest = ExamTest::factory()->create();
    $question = Question::factory()->create([
        'question_category_id' => $category->id,
        'difficulty' => DifficultyLevel::Easy,
        'explanation' => 'This is the explanation',
    ]);
    QuestionAnswer::factory()->count(4)->create([
        'question_id' => $question->id,
    ]);
    $examTest->questions()->attach([$question->id]);

    $service = new ExamPdfExportService;
    $response = $service->generateAnswerKeyPdf($examTest);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers->get('Content-Type'))->toContain('pdf');
});

it('streams exam pdf to browser', function () {
    $category = QuestionCategory::factory()->create();
    $examTest = ExamTest::factory()->create();
    $question = Question::factory()->create([
        'question_category_id' => $category->id,
    ]);
    QuestionAnswer::factory()->count(4)->create([
        'question_id' => $question->id,
    ]);
    $examTest->questions()->attach([$question->id]);

    $service = new ExamPdfExportService;
    $response = $service->streamExamPdf($examTest);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers->get('Content-Type'))->toContain('pdf');
});
