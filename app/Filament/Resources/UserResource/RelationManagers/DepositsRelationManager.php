<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class DepositsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'deposits';

    protected static ?string $recordTitleAttribute = 'user_id';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payment_method')
                    ->options([
                        1 => "Commercial Bank Of Ethiopia",
                        2 => "Bank of Absiniya",
                        3 => "Dashen Bank",
                        4 => "Hibret Bank"
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required(),
                Forms\Components\TextInput::make('transaction_number')
                    ->required()
                // Forms\Components\BelongsToSelect::make('user_id')
                //     ->relationship('user', 'name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('payment_method')
                    ->enum([
                        1 => "Commercial Bank Of Ethiopia",
                        2 => "Bank of Absiniya",
                        3 => "Dashen Bank",
                        4 => "Hibret Bank"
                    ])
                    ->colors([
                        "primary"
                    ])
                    ->label('Payment Method'),
                Tables\Columns\TextColumn::make('amount')->label('Price (ETB)'),
                Tables\Columns\TextColumn::make('transaction_number')->label('Transaction Number'),
                Tables\Columns\BadgeColumn::make('is_on_booking')
                    ->enum([
                        0 => "No",
                        1 => "Yes",
                    ])
                    ->colors([
                        'danger' => fn ($state): bool => $state == 0,
                        'success' => fn ($state): bool => $state == 1
                    ])->label('Is On Booking'),

                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        1 => "Pending",
                        2 => "Approved",
                        3 => "Regected"
                    ])
                    ->colors([
                        'warning' => fn ($state) => $state == 1,
                        'success' => fn ($state): bool => $state == 2,
                        'danger' => fn ($state): bool => $state == 3,
                    ])
            ])
            ->filters([
                //
            ]);
    }
}
