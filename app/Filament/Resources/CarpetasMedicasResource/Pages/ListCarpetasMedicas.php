<?php

namespace App\Filament\Resources\CarpetasMedicasResource\Pages;

use App\Filament\Resources\CarpetasMedicasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarpetasMedicas extends ListRecords
{
    protected static string $resource = CarpetasMedicasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
