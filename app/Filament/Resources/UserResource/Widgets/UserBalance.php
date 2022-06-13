<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\Widget;
use App\Services\GeneralServices;

class UserBalance extends Widget
{
    protected static string $view = 'filament.resources.user-resource.widgets.user-balance';

    public $record;

    public function getBalance()
    {
        $gs = new GeneralServices();
        return $gs->userBalance($this->record);
    }
}
