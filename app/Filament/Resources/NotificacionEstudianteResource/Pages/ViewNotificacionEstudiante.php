<?php

namespace App\Filament\Resources\NotificacionEstudianteResource\Pages;

use App\Filament\Resources\NotificacionEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNotificacionEstudiante extends ViewRecord
{
    protected static string $resource = NotificacionEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
