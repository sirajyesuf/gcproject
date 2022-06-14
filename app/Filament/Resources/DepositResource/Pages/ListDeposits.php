<?php

namespace App\Filament\Resources\DepositResource\Pages;

use App\Filament\Resources\DepositResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use App\Models\Deposit;
use Filament\Forms;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use App\Services\GeneralServices;

class ListDeposits extends ListRecords
{
    protected static string $resource = DepositResource::class;

    protected function getTableQuery(): Builder
    {
        return  Deposit::query()->orderBy('created_at', 'DESC');
    } 

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\BadgeColumn::make('payment_method')
                ->enum([
                    1 => "Commercial Bank Of Ethiopia",
                    2 => "Bank of Absiniya",
                    3 => "Dashen Bank",
                    4 => "Hibret Bank"
                ])
                ->colors([
                    "primary"
                ])
                ->label('Payment Method'),
            Tables\Columns\TextColumn::make('amount')->label('Price (ETB)'),
            Tables\Columns\TextColumn::make('transaction_number')->label('Transaction Number'),
            Tables\Columns\BadgeColumn::make('is_on_booking')
                ->enum([
                    0 => "No",
                    1 => "Yes",
                ])
                ->colors([
                    'danger' => fn ($state): bool => $state == 0,
                    'success' => fn ($state): bool => $state == 1
                ])->label('Is On Booking'),

            Tables\Columns\BadgeColumn::make('status')
                ->enum([
                    1 => "Pending",
                    2 => "Approved",
                    3 => "Regected"
                ])
                ->colors([
                    'warning' => fn ($state) => $state == 1,
                    'success' => fn ($state): bool => $state == 2,
                    'danger' => fn ($state): bool => $state == 3,
                ])
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('approve')
                ->action('approve')
                ->label('Approve')
                ->color('success')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->hidden(fn (Deposit $record): bool => 1 != $record->status),

            Action::make('deny')
                ->action('rejecte')
                ->label('Regecte')
                ->color('danger')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->hidden(fn (Deposit $record): bool => 1 != $record->status),
        ];
    }

    protected function getTableFilters(): array
    {
        return [

            Tables\Filters\SelectFilter::make('status')
                ->options([
                    1 => 'Pending',
                    2 => 'Approved',
                    3 => 'Rejected',
                ]),

        ];
    }


    public function approve(GeneralServices $gs, $record)
    {
        $user = $record->user;
        $record->update([
            'status' => 2
        ]);
        $balance = $gs->userBalance($user);
        $message = "your new Deposit is Approved.your total balance is $balance.";
        $gs->sendSms($user->phone_number, $message);
        if ($record->is_on_booking) {
            $book = Booking::where('deposit_id', $record->id)->first();
            if ($book) {
                $book->update([
                    'draft' => 0
                ]);
            }
        }
    }

    public function rejecte(GeneralServices $gs, $record)
    {
        $user = $record->user;
        $record->update([
            'status' => 3
        ]);
        $balance = $gs->userBalance($user);
        $message = "your new Deposit is Regected.your total balance is $balance.";
        $gs->sendSms($user->phone_number, $message);
       
    }
}
