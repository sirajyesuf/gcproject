<?php

namespace App\Filament\Resources\FeaturedResource\Pages;

use App\Filament\Resources\FeaturedResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Livewire\TemporaryUploadedFile;


class CreateFeatured extends CreateRecord
{
    protected static string $resource = FeaturedResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')->label('Title'),
            Forms\Components\Textarea::make('description')->label('Description'),
            Forms\Components\FileUpload::make('image_path')->label('Photo')
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    return (string) str($file->getClientOriginalName())->prepend('storage/');
                }),
            Forms\Components\BelongsToSelect::make('service_provider_id')
                ->relationship('service_provider', 'name'),

        ];
    }
}
