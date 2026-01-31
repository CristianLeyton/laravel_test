<?php

namespace App\Filament\Resources\AutoridadesResource\Pages;

use App\Filament\Resources\AutoridadesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutoridades extends ListRecords
{
    protected static string $resource = AutoridadesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
