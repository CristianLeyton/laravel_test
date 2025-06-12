<?php

namespace App\Filament\Resources\ArrestosResource\Pages;

use App\Filament\Resources\ArrestosResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageArrestos extends ManageRecords
{
    protected static string $resource = ArrestosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
