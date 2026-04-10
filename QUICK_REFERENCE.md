# 🚀 Quick Reference - Exam Question Bank

## Access Points

### Admin Dashboard
**URL:** `http://localhost:8000/admin`

### Resources
- **Questions** → `/admin/questions`
- **Categories** → `/admin/question-categories`
- **Exam Tests** → `/admin/exam-tests`

---

## Key Files

### Models
```php
App\Models\QuestionCategory      // Subjects/Topics
App\Models\Question              // Exam questions
App\Models\QuestionAnswer        // Answer options
App\Models\ExamTest              // Test collections
```

### Services
```php
App\Services\ExamPdfExportService        // PDF generation
App\Services\RandomTestGeneratorService  // Random tests
```

### Enums
```php
App\DifficultyLevel   // Easy, Medium, Hard
```

---

## Database Tables

| Table | Purpose | Records |
|-------|---------|---------|
| `question_categories` | Question categories | 5 |
| `questions` | Exam questions | 75 |
| `question_answers` | Answer options | 300 |
| `exam_tests` | Test collections | 3 |
| `exam_test_questions` | Question-Test mapping | 30+ |

---

## Common Tasks

### Create a Question Category
```php
QuestionCategory::create([
    'name' => 'Biology',
    'description' => 'Biology questions',
]);
```

### Create a Question
```php
Question::create([
    'question_category_id' => 1,
    'question' => 'What is photosynthesis?',
    'difficulty' => DifficultyLevel::Medium,
    'explanation' => 'Photosynthesis is...',
    'created_by' => auth()->id(),
]);
```

### Add Answers to Question
```php
$question->answers()->create([
    'answer' => 'Correct answer text',
    'is_correct' => true,
]);

$question->answers()->create([
    'answer' => 'Incorrect answer text',
    'is_correct' => false,
]);
```

### Create a Test Manually
```php
$test = ExamTest::create([
    'title' => 'Final Exam',
    'description' => 'Comprehensive final',
    'number_of_questions' => 20,
    'created_by' => auth()->id(),
    'generated_at' => now(),
]);

$test->questions()->attach([1, 2, 3, 4, 5]);
```

### Generate Random Test
```php
$service = new RandomTestGeneratorService();
$test = $service->generateRandomTest(
    title: 'Practice Test',
    description: null,
    numberOfQuestions: 15,
    categoryIds: [1, 2], // Mathematics, English
    difficulties: ['easy', 'medium'],
    createdBy: auth()->id()
);
```

### Export Test to PDF
```php
$service = new ExamPdfExportService();
return $service->generateExamPdf($examTest);
```

### Export with Answer Key
```php
$service = new ExamPdfExportService();
return $service->generateAnswerKeyPdf($examTest);
```

---

## Filament Form Fields

### Question Form
- **Category** - Select from QuestionCategory
- **Question** - Textarea
- **Difficulty** - Select (easy/medium/hard)
- **Explanation** - Textarea
- **Answers** - Repeater with:
  - Answer text
  - Is correct toggle

### Category Form
- **Name** - Text input
- **Description** - Textarea

### ExamTest Form
- **Title** - Text input
- **Description** - Textarea
- **Number of Questions** - Numeric
- **Questions** - Multi-select relationship

---

## Difficulty Levels

```php
DifficultyLevel::Easy    // 'easy'
DifficultyLevel::Medium  // 'medium'
DifficultyLevel::Hard    // 'hard'
```

Color coding in UI:
- 🟢 Easy - Green badge
- 🟡 Medium - Amber badge
- 🔴 Hard - Red badge

---

## API Methods

### Question Model
```php
$question->category()          // QuestionCategory
$question->answers()           // QuestionAnswer collection
$question->examTests()         // ExamTest collection
$question->creator()           // User
```

### ExamTest Model
```php
$test->questions()             // Question collection
$test->creator()               // User
```

### QuestionCategory Model
```php
$category->questions()         // Question collection
```

---

## Query Examples

### Get All Questions by Category
```php
$questions = QuestionCategory::find(1)->questions;
```

### Get Questions by Difficulty
```php
$hardQuestions = Question::where('difficulty', 'hard')->get();
```

### Get Random Questions
```php
$random = Question::inRandomOrder()->limit(10)->get();
```

### Get Test Questions
```php
$testQuestions = $examTest->questions()->get();
```

### Get User's Tests
```php
$myTests = auth()->user()->createdExamTests;
```

---

## Seeding Data

### Run All Seeds
```bash
php artisan db:seed
```

### Run Specific Seeder
```bash
php artisan db:seed --class=ExamQuestionBankSeeder
```

### Refresh Database & Seed
```bash
php artisan migrate:fresh --seed
```

---

## Migration Commands

```bash
php artisan migrate              # Run all migrations
php artisan migrate:rollback     # Rollback last batch
php artisan migrate:reset        # Rollback all
php artisan migrate:refresh      # Reset & run all
php artisan migrate:status       # Show status
```

---

## Cache & Optimization

### Clear Cache
```bash
php artisan cache:clear
php artisan route:cache
php artisan config:cache
```

### Refresh Filament
```bash
php artisan filament:upgrade
php artisan filament:optimize
```

---

## Testing Data

### Verify Seeding
```php
// In tinker
Question::count()              // Should be 75
QuestionCategory::count()      // Should be 5
ExamTest::count()              // Should be 3
```

### Check Relationships
```php
$q = Question::first();
$q->category->name             // Category name
$q->answers()->count()         // Should be 4
$q->creator->name              // Creator name
```

---

## PDF View Location
`resources/views/pdf/exam-test.blade.php`

Customize:
- Font sizes
- Colors
- Spacing
- Badge styling
- Header/footer

---

## Configuration Files

- `.env` - Environment variables
- `config/database.php` - Database settings
- `config/filesystems.php` - File storage
- `config/app.php` - App settings

---

## Artisan Commands

```bash
# Make commands
php artisan make:model ModelName
php artisan make:filament-resource ResourceName
php artisan make:migration migration_name
php artisan make:seeder SeederName
php artisan make:factory FactoryName

# Database
php artisan migrate
php artisan db:seed

# Filament
php artisan filament:install
php artisan filament:make-resource

# Cache
php artisan cache:clear
php artisan route:cache
```

---

## Tinker Examples

```bash
php artisan tinker

# Create
$cat = QuestionCategory::create(['name' => 'Test']);
$q = Question::create([...]);

# Read
$cat = QuestionCategory::find(1);
$questions = Question::all();
$count = Question::count();

# Update
$cat->update(['name' => 'Updated']);

# Delete
$cat->delete();

# Relationships
$cat->questions;
$question->answers;
$test->questions;
```

---

## Important Relationships

```
QuestionCategory (1) -----(M) Questions
        ↓
    15 questions each

Question (1) -----(M) QuestionAnswers
     ↓
    4 answers each

Question (M) -----(M) ExamTests
     ↓
   (via pivot table exam_test_questions)

ExamTest (1) -----(M) Questions
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| PDF not generating | Check DOMPDF installed, view path correct |
| Routes not showing | Run `php artisan route:cache`, clear cache |
| Filament not rendering | Run `php artisan filament:upgrade` |
| Database empty | Run `php artisan db:seed` |
| Models not found | Check namespace, run `composer dump-autoload` |

---

## Resources

- 📚 Filament: https://filamentphp.com
- 🚀 Laravel: https://laravel.com
- 📖 Eloquent: https://laravel.com/docs/eloquent
- 🎨 Tailwind: https://tailwindcss.com

---

**Last Updated:** April 10, 2026 ✅
