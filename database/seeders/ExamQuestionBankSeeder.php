<?php

namespace Database\Seeders;

use App\Models\ExamTest;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamQuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );

        // Create categories
        $categories = [
            ['name' => 'Mathematics', 'description' => 'Basic and advanced mathematics questions'],
            ['name' => 'English', 'description' => 'English language and literature questions'],
            ['name' => 'Science', 'description' => 'Physics, Chemistry, and Biology questions'],
            ['name' => 'History', 'description' => 'World and local history questions'],
            ['name' => 'Programming', 'description' => 'Computer programming and algorithms'],
        ];

        foreach ($categories as $categoryData) {
            QuestionCategory::create($categoryData);
        }

        // Create sample questions for each category
        $questionsPerCategory = 15;
        foreach (QuestionCategory::all() as $category) {
            Question::factory($questionsPerCategory)
                ->create([
                    'question_category_id' => $category->id,
                    'created_by' => $admin->id,
                ])
                ->each(function (Question $question) {
                    // Create 4 answers per question (1 correct, 3 incorrect)
                    $answers = [
                        ['answer' => 'Correct Answer Option', 'is_correct' => true],
                        ['answer' => 'Incorrect Answer Option 1', 'is_correct' => false],
                        ['answer' => 'Incorrect Answer Option 2', 'is_correct' => false],
                        ['answer' => 'Incorrect Answer Option 3', 'is_correct' => false],
                    ];

                    foreach ($answers as $answerData) {
                        $question->answers()->create($answerData);
                    }
                });
        }

        // Create sample exam tests
        $totalQuestions = Question::count();
        for ($i = 0; $i < 3; $i++) {
            $test = ExamTest::create([
                'title' => 'Practice Exam '.($i + 1),
                'description' => 'A comprehensive practice exam with questions from all categories',
                'number_of_questions' => rand(10, 20),
                'created_by' => $admin->id,
                'generated_at' => now(),
            ]);

            // Attach random questions to the exam
            $randomQuestions = Question::inRandomOrder()
                ->limit($test->number_of_questions)
                ->pluck('id')
                ->toArray();

            $test->questions()->attach($randomQuestions);
        }
    }
}
