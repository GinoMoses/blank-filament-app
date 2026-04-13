<?php

namespace App\Filament\Resources\ExamTests\Schemas;

use App\DifficultyLevel;
use App\Models\QuestionCategory;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
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
                Radio::make('generation_type')
                    ->label('How would you like to create this test?')
                    ->options([
                        'manual' => 'Manual Selection',
                        'random' => 'Random Generation',
                    ])
                    ->default('manual')
                    ->inline()
                    ->columnSpanFull(),
                Section::make('Manual Selection')
                    ->schema([
                        Select::make('questions')
                            ->options(function () {
                                return \App\Models\Question::with('category')
                                    ->get()
                                    ->mapWithKeys(fn ($q) => [
                                        $q->id => "#{$q->id} - {$q->category->name}: ".mb_substr($q->question, 0, 50).'...',
                                    ])
                                    ->all();
                            })
                            ->multiple()
                            ->label('Questions to Include')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                Section::make('Random Generation')
                    ->description('Select criteria for randomly generating questions')
                    ->schema([
                        TextInput::make('number_of_questions')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(fn () => \App\Models\Question::count())
                            ->default(10)
                            ->required()
                            ->label('Number of Questions'),
                        Checkbox::make('select_all_categories')
                            ->label('All Categories')
                            ->default(true)
                            ->reactive()
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state) {
                                    $set('category_ids', QuestionCategory::pluck('id')->toArray());
                                }
                            }),
                        Select::make('category_ids')
                            ->multiple()
                            ->options(QuestionCategory::pluck('name', 'id'))
                            ->label('Filter by Categories')
                            ->preload(),
                        Checkbox::make('select_all_difficulties')
                            ->label('All Difficulty Levels')
                            ->default(true)
                            ->reactive()
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state) {
                                    $set('difficulty_levels', [
                                        DifficultyLevel::Easy->value,
                                        DifficultyLevel::Medium->value,
                                        DifficultyLevel::Hard->value,
                                    ]);
                                }
                            }),
                        Select::make('difficulty_levels')
                            ->multiple()
                            ->options([
                                DifficultyLevel::Easy->value => 'Easy',
                                DifficultyLevel::Medium->value => 'Medium',
                                DifficultyLevel::Hard->value => 'Hard',
                            ])
                            ->label('Filter by Difficulty'),
                    ])
                    ->columns(2),
            ]);
    }
}
