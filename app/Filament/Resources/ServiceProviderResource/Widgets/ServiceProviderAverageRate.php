<?php

namespace App\Filament\Resources\ServiceProviderResource\Widgets;

use Filament\Widgets\Widget;
use App\Services\GeneralServices;

class ServiceProviderAverageRate extends Widget
{
    protected static string $view = 'filament.resources.service-provider-resource.widgets.service-provider-average-rate';
    public $record;

    public function getAverageRate()
    {

        $gs = new GeneralServices();
        return $gs->calculateAverageRate($this->record);
    }
}
