<?php

namespace App\Filament\Resources\StudentExamAttempts\Tables;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentExamAttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('examTest.title')
                    ->label('Exam')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'draft' => 'In Progress',
                        'submitted' => 'Submitted',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'draft' => 'warning',
                        'submitted' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn ($state) => $state !== null ? "{$state}%" : '-')
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Started')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('answers_count')
                    ->counts('answers')
                    ->label('Answers'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'In Progress',
                        'submitted' => 'Submitted',
                    ]),
                SelectFilter::make('exam_test_id')
                    ->relationship('examTest', 'title')
                    ->label('Exam'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
            ]);
    }
}
