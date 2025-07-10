<?php

namespace App\Filament\Resources\DomiciliosResource\Pages;

use App\Filament\Resources\DomiciliosResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDomicilios extends ManageRecords
{
    protected static string $resource = DomiciliosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
