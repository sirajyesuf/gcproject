<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\Widget;

class UserBooking extends Widget
{
    protected static string $view = 'filament.resources.user-resource.widgets.user-booking';
    public $record;

    public function getTotalNumberOfBooking()
    {
        return $this->record->bookings()->count();
    }
}
