<?php

namespace App\Filament\Resources\ResolucionesResource\Pages;

use App\Filament\Resources\ResolucionesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResolucion extends CreateRecord
{
    protected static string $resource = ResolucionesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
