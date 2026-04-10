<?php

namespace App\Filament\Resources\ExamTests\Pages;

use App\Filament\Resources\ExamTests\ExamTestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExamTest extends EditRecord
{
    protected static string $resource = ExamTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
