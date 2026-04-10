# Setup & Configuration Guide - Exam Question Bank

## Initial Setup

The Exam Question Bank has been fully initialized in your Laravel application. Here's what was done:

### 1. **Models Created**
- `QuestionCategory` - Categories for organizing questions
- `Question` - Individual exam questions
- `QuestionAnswer` - Answer options for questions
- `ExamTest` - Collections of questions forming a test

### 2. **Database Tables Created**
```
✓ question_categories
✓ questions
✓ question_answers
✓ exam_tests
✓ exam_test_questions (pivot table)
```

### 3. **Filament Resources Created**
- **Question Categories** - Manage question topics/subjects
- **Questions** - CRUD operations for exam questions
- **Exam Tests** - Create and manage exam tests

### 4. **Services Created**
- `ExamPdfExportService` - Generate PDF exams with/without answer keys
- `RandomTestGeneratorService` - Create random test sets

### 5. **Sample Data Populated**
- 5 categories (Math, English, Science, History, Programming)
- 75 questions (15 per category with varying difficulty)
- 3 sample exam tests
- Admin user: `admin@example.com` (password: configured in seeder)

## Quick Start

### Access the Admin Panel

1. Start your Laravel application:
```bash
php artisan serve
```

2. Navigate to: `http://localhost:8000/admin`

3. Login with admin credentials created during seeding

### Create Your First Question

1. Go to **Questions** in the admin menu
2. Click **Create**
3. Fill in:
   - Category (select from dropdown)
   - Question text
   - Difficulty level
   - Optional explanation
   - Add 2-10 answer options
   - Mark the correct answer
4. Save

### Create a Test

1. Go to **Exam Tests**
2. Click **Create**
3. Enter test details:
   - Title
   - Description
   - Number of questions
   - Select specific questions OR use the number to auto-select
4. Save
5. Download as PDF or PDF with Answer Key

### Organize Questions

1. Go to **Question Categories**
2. Create new categories for your subjects
3. Assign questions to categories

## Enum Values

### DifficultyLevel
```php
DifficultyLevel::Easy    // 'easy'
DifficultyLevel::Medium  // 'medium'
DifficultyLevel::Hard    // 'hard'
```

## File Locations

```
app/
  Models/
    - QuestionCategory.php
    - Question.php
    - QuestionAnswer.php
    - ExamTest.php
  Services/
    - ExamPdfExportService.php
    - RandomTestGeneratorService.php
  Filament/Resources/
    - QuestionCategories/
    - Questions/
    - ExamTests/

database/
  migrations/
    - *_create_question_categories_table.php
    - *_create_questions_table.php
    - *_create_question_answers_table.php
    - *_create_exam_tests_table.php
    - *_create_exam_test_questions_table.php
  factories/
    - QuestionCategoryFactory.php
    - QuestionFactory.php
    - QuestionAnswerFactory.php
    - ExamTestFactory.php
  seeders/
    - ExamQuestionBankSeeder.php

resources/views/
  pdf/
    - exam-test.blade.php
```

## Customization Options

### Change Question Categories
Edit `database/seeders/ExamQuestionBankSeeder.php`:
```php
$categories = [
    ['name' => 'Your Category', 'description' => 'Description'],
];
```

### Modify PDF Styling
Edit `resources/views/pdf/exam-test.blade.php` - update the `<style>` section

### Extend Models
Add relationships to models as needed:
```php
// Example: Add tags to questions
Question::hasMany(Tag::class);
```

### Create Additional Services
Extend functionality with your own services using the provided ones as templates

## Security Considerations

1. **Question Visibility** - Currently all questions are accessible to authenticated users
   - Consider adding role-based access control (RBAC)
   - Example: Only teachers can create questions

2. **Answer Key Visibility** - Restrict answer key exports to instructors
   - Add policy checks in Filament actions

3. **Audit Trail** - Track who modified questions
   - Consider adding created_by and updated_by timestamps

## Performance Optimization

For large question banks (1000+ questions):

1. **Add Indexing**:
```php
// In migrations
$table->index('question_category_id');
$table->index('difficulty');
$table->index('created_by');
```

2. **Cache Categories**:
```php
Cache::remember('question_categories', 3600, fn () => 
    QuestionCategory::with('questions')->get()
);
```

3. **Paginate Results**:
```php
Question::paginate(50);
```

## Troubleshooting

### PDF Export Not Working
- Ensure `dompdf` is installed: `composer require barryvdh/laravel-dompdf`
- Check view path: `resources/views/pdf/exam-test.blade.php`

### Questions Not Showing
- Run migrations: `php artisan migrate`
- Check relationships in models
- Verify database connection

### Admin Panel Not Displaying
- Clear cache: `php artisan cache:clear`
- Run Filament upgrade: `php artisan filament:upgrade`

## Additional Resources

- Filament Documentation: https://filamentphp.com/docs
- Laravel Eloquent: https://laravel.com/docs/eloquent
- DOMPDF: https://github.com/barryvdh/laravel-dompdf

## Next Steps

1. **Customize Categories** - Add your specific subjects
2. **Bulk Import** - Create import feature for CSV questions
3. **Student Interface** - Build student test-taking interface
4. **Analytics** - Add performance tracking
5. **Scheduling** - Add test scheduling features

---

**Ready to go!** Start creating questions and managing your exam bank. 📚✏️
