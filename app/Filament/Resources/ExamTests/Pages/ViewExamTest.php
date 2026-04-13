<?php

namespace App\Filament\Resources\ExamTests\Pages;

use App\Filament\Resources\ExamTests\ExamTestResource;
use App\Services\RandomTestGeneratorService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewExamTest extends ViewRecord
{
    protected static string $resource = ExamTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('gray')
                ->url(fn () => route('admin.exam-tests.pdf', ['examTest' => $this->getRecord()])),
            Action::make('downloadPdfWithAnswers')
                ->label('Download PDF with Answer Key')
                ->icon('heroicon-o-document-arrow-down')
                ->color('warning')
                ->url(fn () => route('admin.exam-tests.pdf-with-answers', ['examTest' => $this->getRecord()])),
            Action::make('regenerateQuestions')
                ->label('Regenerate Questions')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->visible(fn () => $this->getRecord()->generation_type === 'random')
                ->requiresConfirmation()
                ->action(function () {
                    $record = $this->getRecord();

                    $service = app(RandomTestGeneratorService::class);
                    $questions = $service->getRandomQuestions(
                        limit: $record->number_of_questions,
                        categoryIds: $record->category_ids,
                        difficulties: $record->difficulty_levels,
                    );

                    $record->questions()->sync($questions->pluck('id')->toArray());
                    $record->update(['generated_at' => now()]);

                    Notification::make()
                        ->title('Questions regenerated')
                        ->success()
                        ->send();
                }),
        ];
    }
}
