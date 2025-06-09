<?php

namespace App\Filament\Resources\NivelesDeFaltasResource\Pages;

use App\Filament\Resources\NivelesDeFaltasResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageNivelesDeFaltas extends ManageRecords
{
    protected static string $resource = NivelesDeFaltasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
