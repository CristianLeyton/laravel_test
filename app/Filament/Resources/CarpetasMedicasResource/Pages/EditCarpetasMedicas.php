<?php

namespace App\Filament\Resources\CarpetasMedicasResource\Pages;

use App\Filament\Resources\CarpetasMedicasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarpetasMedicas extends EditRecord
{
    protected static string $resource = CarpetasMedicasResource::class;

    protected static bool $shouldEditInModal = true;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
