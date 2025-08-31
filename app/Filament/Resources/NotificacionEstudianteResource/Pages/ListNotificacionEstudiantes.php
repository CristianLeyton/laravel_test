<?php

namespace App\Filament\Resources\NotificacionEstudianteResource\Pages;

use App\Filament\Resources\NotificacionEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\NotificacionEstudiante;

class ListNotificacionEstudiantes extends ListRecords
{
    protected static string $resource = NotificacionEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('marcar_todas_leidas')
                ->label('Marcar todas como leídas')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('¿Marcar todas las notificaciones como leídas?')
                ->modalDescription('Esta acción marcará todas las notificaciones como leídas. ¿Deseas continuar?')
                ->action(function () {
                    NotificacionEstudiante::where('leida', false)->update(['leida' => true]);
                }),
        ];
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getTableQuery()
            ->orderBy('created_at', 'desc');
    }
}
