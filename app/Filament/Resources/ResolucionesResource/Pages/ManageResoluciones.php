<?php

namespace App\Filament\Resources\ResolucionesResource\Pages;

use App\Filament\Resources\ResolucionesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageResoluciones extends ManageRecords
{
    protected static string $resource = ResolucionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
