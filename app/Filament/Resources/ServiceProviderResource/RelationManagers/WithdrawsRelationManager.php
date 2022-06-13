<?php

namespace App\Filament\Resources\ServiceProviderResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class WithdrawsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'withdraws';

    protected static ?string $recordTitleAttribute = 'service_provider_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount (ETB)'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => fn ($state): bool => $state == 1,
                        'danger' => fn ($state): bool => $state == 2,
                        'success' => fn ($state): bool => $state == 3,
                    ])->enum([
                        1 => "Pending",
                        2 => "Rejected",
                        3 => "Paid"
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([]);
    }
}
