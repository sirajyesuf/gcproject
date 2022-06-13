<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use App\Models\Service;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getTableColumns(): array
    {
        return [
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
        ];
    }
}
