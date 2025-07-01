<?php

namespace App\Filament\Resources\NotificacionEstudianteResource\Pages;

use App\Filament\Resources\NotificacionEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificacionEstudiante extends EditRecord
{
    protected static string $resource = NotificacionEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
