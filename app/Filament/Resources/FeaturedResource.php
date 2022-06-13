<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeaturedResource\Pages;
use App\Filament\Resources\FeaturedResource\RelationManagers;
use App\Models\Featured;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FeaturedResource extends Resource
{
    protected static ?string $model = Featured::class;

    protected static ?string $navigationIcon = 'heroicon-s-star';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('title')->label('Title'),
                Forms\Components\Textarea::make('description')->label('Description'),
                Forms\Components\FileUpload::make('image_path')->label('Photo'),
                Forms\Components\BelongsToSelect::make('service_provider_id')
                    ->relationship('service_provider', 'business_name'),
                Forms\Components\Toggle::make('status')->inline()->label('Enabled')

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatureds::route('/'),
            'create' => Pages\CreateFeatured::route('/create'),
            'edit' => Pages\EditFeatured::route('/{record}/edit'),
        ];
    }
}
