<?php

namespace App\Filament\Resources\StudentExamAttempts\Pages;

use App\Filament\Resources\StudentExamAttempts\StudentExamAttemptResource;
use Filament\Resources\Pages\ListRecords;

class ListStudentExamAttempts extends ListRecords
{
    protected static string $resource = StudentExamAttemptResource::class;
}
