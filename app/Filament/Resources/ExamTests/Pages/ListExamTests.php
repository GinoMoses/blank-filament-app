<?php

namespace App\Filament\Resources\ExamTests\Pages;

use App\Filament\Resources\ExamTests\ExamTestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamTests extends ListRecords
{
    protected static string $resource = ExamTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
