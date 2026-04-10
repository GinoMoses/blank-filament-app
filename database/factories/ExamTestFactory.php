<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamTest>
 */
class ExamTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(4, true),
            'description' => $this->faker->paragraph(),
            'number_of_questions' => $this->faker->numberBetween(5, 30),
            'created_by' => User::factory(),
            'generated_at' => $this->faker->dateTimeBetween('-1 month'),
        ];
    }
}
