<?php

namespace App\Filament\Resources\CarpetasMedicasResource\Pages;

use App\Filament\Resources\CarpetasMedicasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCarpetasMedicas extends CreateRecord
{
    protected static string $resource = CarpetasMedicasResource::class;

    protected static bool $shouldCreateInModal = true;
}
