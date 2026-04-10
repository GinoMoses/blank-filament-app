<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentExamAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'exam_test_id',
        'started_at',
        'submitted_at',
        'score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'score' => 'integer',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function examTest(): BelongsTo
    {
        return $this->belongsTo(ExamTest::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function calculateScore(): int
    {
        $correct = $this->answers()->where('is_correct', true)->count();
        $total = $this->answers()->count();

        return $total > 0 ? (int) (($correct / $total) * 100) : 0;
    }
}
