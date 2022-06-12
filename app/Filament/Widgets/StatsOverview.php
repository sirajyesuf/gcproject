<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Models\Service;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Service Providers', ServiceProvider::count())
                ->description('32 increase from last week')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Total Users', User::count())
                ->description('10 increase from last week')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 90, 15, 4, 17])
                ->color('success'),
            Card::make('Total Service', User::count())
                ->description('10 increase from last week')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 90, 15, 4, 17])
                ->color('success'),
        ];
    }
}
