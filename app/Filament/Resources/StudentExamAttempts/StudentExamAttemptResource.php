<?php

namespace App\Filament\Resources\StudentExamAttempts;

use App\Filament\Resources\StudentExamAttempts\Pages\ListStudentExamAttempts;
use App\Filament\Resources\StudentExamAttempts\Pages\ViewStudentExamAttempt;
use App\Filament\Resources\StudentExamAttempts\Tables\StudentExamAttemptsTable;
use App\Models\StudentExamAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentExamAttemptResource extends Resource
{
    protected static ?string $model = StudentExamAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $label = 'Exam Attempts';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return StudentExamAttemptsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentExamAttempts::route('/'),
            'view' => ViewStudentExamAttempt::route('/{record}'),
        ];
    }
}
