<?php

namespace App\Filament\Resources\ExamTests;

use App\Filament\Resources\ExamTests\Pages\CreateExamTest;
use App\Filament\Resources\ExamTests\Pages\EditExamTest;
use App\Filament\Resources\ExamTests\Pages\ListExamTests;
use App\Filament\Resources\ExamTests\Schemas\ExamTestForm;
use App\Filament\Resources\ExamTests\Tables\ExamTestsTable;
use App\Models\ExamTest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamTestResource extends Resource
{
    protected static ?string $model = ExamTest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function form(Schema $schema): Schema
    {
        return ExamTestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamTestsTable::configure($table);
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
            'index' => ListExamTests::route('/'),
            'create' => CreateExamTest::route('/create'),
            'edit' => EditExamTest::route('/{record}/edit'),
        ];
    }
}
