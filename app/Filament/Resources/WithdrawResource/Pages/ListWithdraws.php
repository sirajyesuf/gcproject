<?php

namespace App\Filament\Resources\WithdrawResource\Pages;

use App\Filament\Resources\WithdrawResource;
use App\Models\Withdraw;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class ListWithdraws extends ListRecords
{
    protected static string $resource = WithdrawResource::class;

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('amount')->label('Amount (ETB)'),
            Tables\Columns\TextColumn::make('withdraw'),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'primary' => fn ($state): bool => $state == 1,
                    'danger' => fn ($state): bool => $state == 2,
                    'success' => fn ($state): bool => $state == 3,
                ])->enum([
                    1 => "Pending",
                    2 => "Rejected",
                    3 => "Paid"
                ]),
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
                ->hidden(fn (Withdraw $record): bool => 1 != $record->status),

            Action::make('deny')
                ->action('rejecte')
                ->label('Deny')
                ->color('danger')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->hidden(fn (Withdraw $record): bool => 1 != $record->status),
        ];
    }

    // 1 for pending
    // 2 for rejecte
    // 3 for paid

    public function approve($record)
    {

        $record->update([
            'status' => 3
        ]);
    }
    public function rejecte($record)
    {
        $record->update([
            'status' => 2
        ]);
    }
}
