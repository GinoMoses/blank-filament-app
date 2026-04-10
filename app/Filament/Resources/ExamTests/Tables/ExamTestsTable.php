<?php

namespace App\Filament\Resources\ExamTests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExamTestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('number_of_questions')
                    ->label('Questions'),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Questions Added'),
                BadgeColumn::make('generated_at')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Generated' : 'Draft'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
