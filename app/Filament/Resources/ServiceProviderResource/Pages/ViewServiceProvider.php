<?php

namespace App\Filament\Resources\ServiceProviderResource\Pages;

use App\Filament\Resources\ServiceProviderResource;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ServiceProviderResource\Widgets\ServiceProviderBalance as  ServiceProviderBalance;
use App\Filament\Resources\ServiceProviderResource\Widgets\ServiceProviderAverageRate as ServiceProviderAverageRate;
class ViewServiceProvider extends ViewRecord
{
    protected static string $resource = ServiceProviderResource::class;
    protected static ?string $title = 'Service Provider Detail';

    protected function getHeaderWidgets(): array
    {
        return [

            ServiceProviderBalance::class,
            ServiceProviderAverageRate::class,

        ];
    }
}
