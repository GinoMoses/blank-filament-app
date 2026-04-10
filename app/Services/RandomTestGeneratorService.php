<?php

namespace App\Services;

use App\Models\ExamTest;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class RandomTestGeneratorService
{
    /**
     * Generate a random test from available questions
     */
    public function generateRandomTest(
        string $title,
        ?string $description,
        int $numberOfQuestions,
        ?array $categoryIds = null,
        ?array $difficulties = null,
        ?int $createdBy = null
    ): ExamTest {
        // Build query
        $query = Question::query();

        // Filter by categories if specified
        if ($categoryIds && ! empty($categoryIds)) {
            $query->whereIn('question_category_id', $categoryIds);
        }

        // Filter by difficulties if specified
        if ($difficulties && ! empty($difficulties)) {
            $query->whereIn('difficulty', $difficulties);
        }

        // Get random questions
        $questions = $query->inRandomOrder()
            ->limit($numberOfQuestions)
            ->pluck('id')
            ->toArray();

        if (empty($questions)) {
            throw new \Exception('No questions available matching the specified criteria');
        }

        // Create exam test
        $examTest = ExamTest::create([
            'title' => $title,
            'description' => $description,
            'number_of_questions' => count($questions),
            'created_by' => $createdBy ?? 1,
            'generated_at' => now(),
        ]);

        // Attach questions
        $examTest->questions()->attach($questions);

        return $examTest;
    }

    /**
     * Get random questions from database
     */
    public function getRandomQuestions(
        int $limit = 10,
        ?array $categoryIds = null,
        ?array $difficulties = null
    ): Collection {
        $query = Question::query();

        if ($categoryIds && ! empty($categoryIds)) {
            $query->whereIn('question_category_id', $categoryIds);
        }

        if ($difficulties && ! empty($difficulties)) {
            $query->whereIn('difficulty', $difficulties);
        }

        return $query->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
