<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\DifficultyLevel;
use App\Models\QuestionCategory;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('question_category_id')
                    ->relationship('category', 'name')
                    ->options(QuestionCategory::pluck('name', 'id'))
                    ->required()
                    ->label('Category'),
                Textarea::make('question')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Select::make('difficulty')
                    ->options([
                        DifficultyLevel::Easy->value => 'Easy',
                        DifficultyLevel::Medium->value => 'Medium',
                        DifficultyLevel::Hard->value => 'Hard',
                    ])
                    ->default(DifficultyLevel::Medium->value)
                    ->required(),
                Textarea::make('explanation')
                    ->label('Explanation / Solution')
                    ->rows(3)
                    ->columnSpanFull(),
                Repeater::make('answers')
                    ->relationship('answers')
                    ->schema([
                        Textarea::make('answer')
                            ->required()
                            ->rows(2),
                        Toggle::make('is_correct')
                            ->label('Correct Answer'),
                    ])
                    ->minItems(2)
                    ->maxItems(10)
                    ->columnSpanFull(),
            ]);
    }
}
