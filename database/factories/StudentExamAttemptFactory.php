<?php

namespace Database\Factories;

use App\Models\ExamTest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentExamAttempt>
 */
class StudentExamAttemptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'exam_test_id' => ExamTest::factory(),
            'started_at' => now()->addSeconds(fake()->unique()->numberBetween(1, 10000)),
            'submitted_at' => null,
            'score' => null,
            'status' => 'draft',
        ];
    }

    public function submitted(): static
    {
        return $this->state(fn (array $attributes) => [
            'submitted_at' => now(),
            'score' => fake()->numberBetween(0, 100),
            'status' => 'submitted',
        ]);
    }
}
