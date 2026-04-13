<?php

namespace App\Filament\Resources\ExamTests\Pages;

use App\Filament\Resources\ExamTests\ExamTestResource;
use App\Services\RandomTestGeneratorService;
use Filament\Resources\Pages\CreateRecord;

class CreateExamTest extends CreateRecord
{
    protected static string $resource = ExamTestResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();

        if ($record->generation_type === 'random') {
            $categoryIds = $record->category_ids;
            $difficultyLevels = $record->difficulty_levels;

            $service = app(RandomTestGeneratorService::class);
            $questions = $service->getRandomQuestions(
                limit: $record->number_of_questions,
                categoryIds: $categoryIds,
                difficulties: $difficultyLevels,
            );

            $record->questions()->sync($questions->pluck('id')->toArray());
            $record->update([
                'generated_at' => now(),
                'is_auto_generated' => true,
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        $record = $this->getRecord();

        if ($record->generation_type === 'random') {
            return ExamTestResource::getUrl('view', ['record' => $record]);
        }

        return parent::getRedirectUrl();
    }
}
