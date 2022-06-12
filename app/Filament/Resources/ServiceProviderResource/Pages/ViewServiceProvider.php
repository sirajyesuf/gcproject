<?php

namespace App\Filament\Resources\ServiceProviderResource\Pages;

use App\Filament\Resources\ServiceProviderResource;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceProvider extends ViewRecord
{
    protected static string $resource = ServiceProviderResource::class;
    protected static ?string $title = 'services';


}
