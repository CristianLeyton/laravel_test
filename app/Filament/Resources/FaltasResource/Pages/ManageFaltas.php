<?php

namespace App\Filament\Resources\FaltasResource\Pages;

use App\Filament\Resources\FaltasResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFaltas extends ManageRecords
{
    protected static string $resource = FaltasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
