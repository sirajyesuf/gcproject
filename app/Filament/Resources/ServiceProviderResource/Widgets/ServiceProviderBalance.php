<?php

namespace App\Filament\Resources\ServiceProviderResource\Widgets;

use Filament\Widgets\Widget;

use App\Models\ServiceProvider;
use App\Services\GeneralServices;


class ServiceProviderBalance extends Widget
{
    protected static string $view = 'filament.resources.service-provider-resource.widgets.service-provider-balance';

    public $record;

    public function getTotalBalance()
    {   $gs = new GeneralServices();
        return $gs->serviceProviderTotalBalance($this->record);
    }
}
