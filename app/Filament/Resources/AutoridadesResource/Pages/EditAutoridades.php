<?php

namespace App\Filament\Resources\AutoridadesResource\Pages;

use App\Filament\Resources\AutoridadesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAutoridades extends EditRecord
{
    protected static string $resource = AutoridadesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
