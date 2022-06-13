<?php

namespace App\Filament\Widgets;

use Filament\Widgets\DoughnutChartWidget;

class BookingChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Booking';

    protected function getData(): array
    {
        return [
            //
        ];
    }
}
