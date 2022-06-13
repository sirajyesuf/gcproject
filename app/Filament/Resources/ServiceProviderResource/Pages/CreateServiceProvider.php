<?php

namespace App\Filament\Resources\ServiceProviderResource\Pages;

use App\Filament\Resources\ServiceProviderResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;

class CreateServiceProvider extends CreateRecord
{
    protected static string $resource = ServiceProviderResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('business_name')
        ];
    }
}
