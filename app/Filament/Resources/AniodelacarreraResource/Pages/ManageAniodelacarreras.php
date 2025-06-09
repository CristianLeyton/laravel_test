<?php

namespace App\Filament\Resources\AniodelacarreraResource\Pages;

use App\Filament\Resources\AniodelacarreraResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAniodelacarreras extends ManageRecords
{
    protected static string $resource = AniodelacarreraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
