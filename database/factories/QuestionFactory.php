<?php

namespace Database\Factories;

use App\DifficultyLevel;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_category_id' => QuestionCategory::factory(),
            'question' => $this->faker->sentence(8).'?',
            'difficulty' => $this->faker->randomElement(DifficultyLevel::cases()),
            'explanation' => $this->faker->paragraph(),
            'created_by' => User::factory(),
        ];
    }
}
