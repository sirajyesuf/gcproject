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
            ->schema([]);
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
            'view' => Pages\ViewServiceProvider::route('/{record}'),
            // 'create' => Pages\CreateServiceProvider::route('/create'),
            // 'edit' => Pages\EditServiceProvider::route('/{record}/edit'),
        ];
    }
}
