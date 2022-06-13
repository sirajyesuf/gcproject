<?php

namespace App\Filament\Resources\FeaturedResource\Pages;

use App\Filament\Resources\FeaturedResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use App\Models\Featured;

class ListFeatureds extends ListRecords
{
    protected static string $resource = FeaturedResource::class;

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('description')->wrap(),
            Tables\Columns\TextColumn::make('image_path')->limit(10)
                ->url(fn (Featured $record): string =>  asset($record->image_path))
                ->openUrlInNewTab()->label('Photo'),
            Tables\Columns\BadgeColumn::make('status')->enum([
                1 => 'ON',
                0 => 'OFF'
            ])
                ->colors([
                    'success' => fn ($state): bool => $state == 1,
                    'danger' => fn ($state): bool => $state == 0,
                ])
        ];
    }

    
}
