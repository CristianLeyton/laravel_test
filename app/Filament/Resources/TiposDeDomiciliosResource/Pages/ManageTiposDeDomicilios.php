<?php

namespace App\Filament\Resources\TiposDeDomiciliosResource\Pages;

use App\Filament\Resources\TiposDeDomiciliosResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTiposDeDomicilios extends ManageRecords
{
    protected static string $resource = TiposDeDomiciliosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
