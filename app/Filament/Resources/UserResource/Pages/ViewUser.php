<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserResource\Widgets\UserBalance as UserBalance;
use App\Filament\Resources\UserResource\Widgets\UserBooking as UserBooking;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [

            UserBalance::class,
            UserBooking::class

        ];
    }
}
