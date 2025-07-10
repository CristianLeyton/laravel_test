<?php

namespace App\Filament\Resources\ResolucionesResource\Pages;

use App\Filament\Resources\ResolucionesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResolucion extends EditRecord
{
    protected static string $resource = ResolucionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
