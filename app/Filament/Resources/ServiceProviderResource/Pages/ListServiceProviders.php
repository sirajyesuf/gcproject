<?php

namespace App\Filament\Resources\ServiceProviderResource\Pages;

use App\Filament\Resources\ServiceProviderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use App\Models\ServiceProvider;

class ListServiceProviders extends ListRecords
{
    protected static string $resource = ServiceProviderResource::class;

    protected function getTableColumns(): array
    {
        return [

            Tables\Columns\TextColumn::make('business_name')->label('Business Name'),
            Tables\Columns\TextColumn::make('owner_name')->label('Owner Name'),
            Tables\Columns\BadgeColumn::make('phone_number')->label('Phone Number'),
            Tables\Columns\TextColumn::make('logo')->limit(10)
                ->url(fn (ServiceProvider $record): string =>  asset($record->logo))
                ->openUrlInNewTab(),



        ];
    }
}
