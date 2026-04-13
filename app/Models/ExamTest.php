<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExamTest extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (ExamTest $examTest) {
            if (empty($examTest->created_by)) {
                $user = Filament::auth()->user();
                $examTest->created_by = $user?->id ?? 1;
            }
        });
    }

    protected $fillable = [
        'title',
        'description',
        'number_of_questions',
        'generation_type',
        'category_ids',
        'difficulty_levels',
        'is_auto_generated',
        'created_by',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
            'category_ids' => 'array',
            'difficulty_levels' => 'array',
            'is_auto_generated' => 'boolean',
        ];
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_test_questions')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
