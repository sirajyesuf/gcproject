<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositResource\Pages;
use App\Filament\Resources\DepositResource\RelationManagers;
use App\Models\Deposit;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                    ->required(),
                Forms\Components\BelongsToSelect::make('user_id')
                    ->relationship('user', 'name')->required(),
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
                Tables\Columns\BadgeColumn::make('status')
                ->enum([
                    1=>"Approved",
                    2=>"Denied"
                ])
            ])
            ->filters([
                //
            ]);
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
            'index' => Pages\ListDeposits::route('/'),
            'create' => Pages\CreateDeposit::route('/create'),
            'edit' => Pages\EditDeposit::route('/{record}/edit'),
        ];
    }
}
