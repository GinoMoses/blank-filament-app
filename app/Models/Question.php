<?php

namespace App\Models;

use App\DifficultyLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_category_id',
        'question',
        'difficulty',
        'explanation',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'difficulty' => DifficultyLevel::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function examTests(): BelongsToMany
    {
        return $this->belongsToMany(ExamTest::class, 'exam_test_questions')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
