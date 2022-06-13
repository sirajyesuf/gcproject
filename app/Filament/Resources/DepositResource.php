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
use Filament\Tables\Actions\Action;

class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

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

                //
            ])
            ->filters([
                //
            ])
            ->actions([

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
