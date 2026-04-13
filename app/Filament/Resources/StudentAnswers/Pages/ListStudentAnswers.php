<?php

namespace App\Filament\Resources\StudentAnswers\Pages;

use App\Filament\Resources\StudentAnswers\StudentAnswerResource;
use Filament\Resources\Pages\ListRecords;

class ListStudentAnswers extends ListRecords
{
    protected static string $resource = StudentAnswerResource::class;
}
