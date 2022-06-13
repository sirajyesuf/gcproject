<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Models\Booking;

class BookingsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\BelongsToSelect::make('Service Provider')
            ->relationship('serviceProvider','business_name')
            ]);
    }

    public static function table(Table $table): Table
    {


        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->url(fn (Booking $record): string => $record->service->id),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        1 => "BOOKED",
                        2 => "DONE"
                    ])
                    ->colors([
                        'warning' => fn ($state) => $state == 1,
                        'success' => fn ($state) => $state == 2
                    ])
            ])
            ->filters([
                //
            ]);
    }
}
