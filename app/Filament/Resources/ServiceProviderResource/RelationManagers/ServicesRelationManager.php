<?php

namespace App\Filament\Resources\ServiceProviderResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\Service;

class ServicesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $recordTitleAttribute = 'service_provider_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('price')->numeric(),
                Forms\Components\Select::make('type')
                ->options([
                    1 => 'Male',
                    2 => 'Female',
                ]),
                Forms\Components\FileUpload::make('image')




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('description')->label('Description')->wrap(),
                Tables\Columns\TextColumn::make('price')->label('Price (ETB)'),
                Tables\Columns\BadgeColumn::make('type')->enum([
                    1 => "Male",
                    2 => "Female"
                ])->colors([
                    'success' => 1,
                    'warning' => 2,
                ]),
                Tables\Columns\TextColumn::make('image')->limit(10)
                    ->url(fn (Service $record): string =>  asset($record->image))
                    ->openUrlInNewTab()
            ])
            ->filters([
                //
            ]);
            // ->actions([
            //     // ...
            // ])
            // ->bulkActions([
            //     // ...
            // ]);
    }
}
