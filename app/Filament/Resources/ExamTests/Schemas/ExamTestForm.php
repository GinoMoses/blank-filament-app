<?php

namespace App\Filament\Resources\ExamTests\Schemas;

use App\Models\Question;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamTestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Test Title'),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                TextInput::make('number_of_questions')
                    ->numeric()
                    ->minValue(1)
                    ->default(10)
                    ->required()
                    ->label('Number of Questions'),
                Select::make('questions')
                    ->relationship('questions', 'question')
                    ->options(fn () => Question::pluck('question', 'id'))
                    ->multiple()
                    ->preload()
                    ->label('Questions to Include')
                    ->columnSpanFull(),
            ]);
    }
}
