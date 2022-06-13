<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceProviderResource\Pages;
use App\Filament\Resources\ServiceProviderResource\RelationManagers;
use App\Models\ServiceProvider;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use App\Filament\Resources\ServiceProviderResource\RelationManagers\ServicesRelationManager as ServicesRelationManager;

class ServiceProviderResource extends Resource
{
    protected static ?string $model = ServiceProvider::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('business_name')->label('Business Name')
                ->required(),
                Forms\Components\TextInput::make('phone_number')->label('Phone Number')->tel()
                ->required(),
                Forms\Components\TextInput::make('owner_name')->label('Owner Name')
                ->required(),
                Forms\Components\FileUpload::make('logo')->label('Logo')
                ->required(),
                Forms\Components\TextInput::make('latitude')->label('Latitude')
                ->required(),
                Forms\Components\TextInput::make('longitude')->label('Longitude')
                ->required(),
                Forms\Components\Select::make('type')->options([
                    1 => 'Male',
                    2 => 'Female'
                ])
                ->required(),






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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ServicesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceProviders::route('/'),
            'create' => Pages\CreateServiceProvider::route('/create'),
            'edit' => Pages\EditServiceProvider::route('/{record}/edit'),
            'view' => Pages\ViewServiceProvider::route('/{record}'),

        ];
    }
}
