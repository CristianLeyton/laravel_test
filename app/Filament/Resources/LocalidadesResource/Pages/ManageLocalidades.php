<?php

namespace App\Filament\Resources\LocalidadesResource\Pages;

use App\Filament\Resources\LocalidadesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLocalidades extends ManageRecords
{
    protected static string $resource = LocalidadesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
