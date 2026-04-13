# Bank Pytań Egzaminacyjnych

A Laravel-based exam question bank system with Filament admin panel for teachers and a student exam interface.

## Tech Stack

- **PHP** 8.2+
- **Laravel** 12
- **Filament** 5 (Admin Panel)
- **Tailwind CSS** 4
- **SQLite** (default database)
- **DomPDF** (PDF export)
- **Pest** 4 (testing)

## Installation

```bash
git clone https://github.com/GinoMoses/blank-filament-app.git
cd blank-filament-app
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

## Demo Accounts

After running `php artisan migrate --seed`, the following test accounts are created automatically:

| Role | Email | Password |
|------|-------|----------|
| Admin/Teacher | admin@example.com | password |
| Student | student@example.com | password |

## Quick Start

```bash
# Start the development server
composer run dev

# Run tests
php artisan test
```

The app will be available at `http://localhost:8000`

## How to Use

### For Teachers (Admin Panel)

1. **Login** at `/admin` with the admin account
2. **Manage Questions** at `/admin/questions`
   - Create questions with multiple choice answers
   - Assign categories and difficulty levels
   - Add explanations for correct answers
3. **Manage Categories** at `/admin/question-categories`
   - Organize questions by subject/topic
4. **Create Exam Tests** at `/admin/exam-tests`
   - Choose between manual selection or random generation
   - Filter questions by category and difficulty
   - Download tests as PDF (with or without answer key)
5. **View Student Attempts** at `/admin/student-exam-attempts`
   - Monitor student progress and scores

### For Students

1. **Login** at `/login` with the student account
2. **Browse Exams** at `/exams`
   - View available exams
   - See your previous attempt scores
3. **Take Exam**
   - Answer multiple choice questions
   - Submit when complete
   - View results with correct answers

### PDF Export

Teachers can download exam PDFs:
- **Without answers** - For student use
- **With answer key** - For grading reference

## Features

- ✅ Question bank with categories and difficulty levels
- ✅ Multiple choice questions (1 correct + 3 incorrect)
- ✅ Manual or random test generation
- ✅ PDF export with/without answer key
- ✅ Student exam attempts and scoring
- ✅ Detailed explanations for answers
- ✅ Bilingual content (Polish/English)

## Testing

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## Code Formatting

```bash
vendor/bin/pint
```
