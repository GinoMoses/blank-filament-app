# 📝 Bank Pytań Egzaminacyjnych (Exam Question Bank)

## Overview

The Exam Question Bank is a comprehensive system for managing educational assessments. It allows teachers to create, organize, and manage a database of exam questions with different difficulty levels and categories, and automatically generate random test sets.

## Features

### 1. **Question Management**
- Create and organize questions with:
  - Multiple categories
  - Three difficulty levels: Easy, Medium, Hard
  - Detailed explanations/solutions
  - Support for multiple-choice answers
- Search and filter questions by category and difficulty
- View and edit questions in an intuitive Filament interface

### 2. **Question Categories**
- Create custom question categories
- Organize questions by subject matter
- Track number of questions per category
- View and manage categories through the admin panel

### 3. **Multiple Choice Answers**
- Support for multiple answer options per question
- Mark correct answers
- Store answer explanations

### 4. **Exam Test Generation**
- Manually create exam tests by selecting specific questions
- Automatically generate random test sets with:
  - Customizable number of questions
  - Filter by category
  - Filter by difficulty level
- Track test metadata (creation date, creator)

### 5. **PDF Export**
- Export exam tests to PDF format
- Generate beautiful, formatted exam papers
- Export answer keys with explanations
- Professional styling with:
  - Question numbering
  - Category badges
  - Difficulty indicators
  - Answer shuffling

## Database Schema

### Tables

#### `question_categories`
- `id` - Primary key
- `name` - Category name
- `description` - Category description
- `timestamps` - Created and updated dates

#### `questions`
- `id` - Primary key
- `question_category_id` - Foreign key to categories
- `question` - Question text
- `difficulty` - Enum (easy, medium, hard)
- `explanation` - Detailed explanation/solution
- `created_by` - Foreign key to users
- `timestamps` - Created and updated dates

#### `question_answers`
- `id` - Primary key
- `question_id` - Foreign key to questions
- `answer` - Answer text
- `is_correct` - Boolean flag for correct answer
- `timestamps` - Created and updated dates

#### `exam_tests`
- `id` - Primary key
- `title` - Test title
- `description` - Test description
- `number_of_questions` - Expected number of questions
- `created_by` - Foreign key to users
- `generated_at` - Timestamp when test was generated
- `timestamps` - Created and updated dates

#### `exam_test_questions` (Pivot Table)
- `id` - Primary key
- `exam_test_id` - Foreign key to exam_tests
- `question_id` - Foreign key to questions
- `order` - Question order in test
- `timestamps` - Created and updated dates

## Models

### QuestionCategory
- `hasMany` questions

### Question
- `belongsTo` QuestionCategory
- `hasMany` answers
- `belongsToMany` ExamTests (via exam_test_questions)
- `belongsTo` User (creator)

### QuestionAnswer
- `belongsTo` Question

### ExamTest
- `belongsToMany` Questions (via exam_test_questions)
- `belongsTo` User (creator)

### User
- `hasMany` createdQuestions
- `hasMany` createdExamTests

## Services

### ExamPdfExportService
Handles PDF generation for exam tests:
- `generateExamPdf($examTest, $includeAnswers)` - Generate exam PDF
- `generateAnswerKeyPdf($examTest)` - Generate answer key
- `streamExamPdf($examTest, $includeAnswers)` - Stream PDF to browser

### RandomTestGeneratorService
Generates random exam tests:
- `generateRandomTest($title, $description, $numberOfQuestions, $categoryIds, $difficulties, $createdBy)` - Create random test
- `getRandomQuestions($limit, $categoryIds, $difficulties)` - Get random questions

## Filament Resources

### QuestionCategory Resource
- List, create, and edit question categories
- View question count per category

### Question Resource
- Full CRUD operations for questions
- Inline answer management with repeater
- Filter by category and difficulty
- Search by question text
- Difficulty level color badges

### ExamTest Resource
- Create and manage exam tests
- Select specific questions for a test
- View test generation status
- PDF export actions

## Usage Examples

### Creating a Question

1. Navigate to Questions in the admin panel
2. Click "Create"
3. Select category
4. Enter question text
5. Choose difficulty level
6. Add explanation
7. Add answer options (minimum 2, maximum 10)
8. Mark the correct answer with the toggle
9. Save

### Generating a Random Test

1. Navigate to Exam Tests
2. Click "Create"
3. Enter test title and description
4. Set number of questions
5. Optionally select specific questions to include
6. Save and use the PDF export features

### Exporting to PDF

1. Go to Exam Tests list
2. Find the desired test
3. Click "Export PDF" for exam only
4. Or click "Answer Key" for exam with answer key and explanations

## Sample Data

The application comes with seed data including:
- 5 question categories (Mathematics, English, Science, History, Programming)
- 75 sample questions (15 per category)
- 3 practice exams

Run `php artisan db:seed` to populate the database.

## Enums

### DifficultyLevel
- `Easy` = 'easy'
- `Medium` = 'medium'
- `Hard` = 'hard'

## API & Services Integration

The system can be extended with:
- API endpoints for question retrieval
- Integration with learning management systems (LMS)
- Student test taking interface
- Performance analytics

## Security

- Questions are associated with creators (users)
- Ability to expand with role-based access control
- Answer keys can be restricted to teachers only

## Future Enhancements

- [ ] Student test-taking interface
- [ ] Performance tracking and analytics
- [ ] Bulk question import (CSV)
- [ ] Question tagging system
- [ ] Test scheduling
- [ ] Automatic grading for student submissions
- [ ] Mobile app for test taking
- [ ] Question bank statistics and reports
