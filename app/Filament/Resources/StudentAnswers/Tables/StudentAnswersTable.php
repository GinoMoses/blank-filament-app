<?php

namespace App\Filament\Resources\StudentAnswers\Tables;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentAnswersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('attempt.student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('attempt.examTest.title')
                    ->label('Exam')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('question.question')
                    ->label('Question')
                    ->limit(60)
                    ->sortable(),
                TextColumn::make('selectedAnswer.answer')
                    ->label('Selected Answer')
                    ->limit(40)
                    ->placeholder('No answer'),
                BadgeColumn::make('is_correct')
                    ->label('Result')
                    ->formatStateUsing(fn ($state) => $state ? 'Correct' : 'Incorrect')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                SelectFilter::make('is_correct')
                    ->options([
                        '1' => 'Correct',
                        '0' => 'Incorrect',
                    ])
                    ->label('Result'),
                SelectFilter::make('attempt_id')
                    ->relationship('attempt', 'id')
                    ->label('Attempt'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
