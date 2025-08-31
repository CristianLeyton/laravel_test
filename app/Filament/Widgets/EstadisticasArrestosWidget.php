<?php

namespace App\Filament\Widgets;

use App\Models\Estudiantes;
use App\Models\Arrestos;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Resources\EstudiantesResource;

class EstadisticasArrestosWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $anioActual = now()->year;
        $totalEstudiantes = Estudiantes::count();
        $estudiantesConArrestos = Estudiantes::whereHas('arrestos')->count();
        $estudiantesActivos = Estudiantes::whereHas('estado', function ($query) {
            $query->where('nombre_estado', 'Activo');
        })->count();
        $estudiantesDadosDeBaja = Estudiantes::whereHas('estado', function ($query) {
            $query->where('nombre_estado', 'Dado de baja');
        })->count();

        return [
            Stat::make('Cadetes Activos', $estudiantesActivos)
                ->description('Cadetes activos')
                ->descriptionIcon('heroicon-m-check-circle')
                ->url(EstudiantesResource::getUrl('index'))
                ->color('success'),


            Stat::make('Cadetes con Arrestos', $estudiantesConArrestos)
                ->description('Cadetes con arrestos')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),


            Stat::make('Cadetes Dados de Baja', $estudiantesDadosDeBaja)
                ->description('Cadetes dados de baja')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

                Stat::make('Total de Cadetes', $totalEstudiantes)
                    ->description('Registrados en el sistema')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('primary')
                    ->url(EstudiantesResource::getUrl('index'))
                    ->openUrlInNewTab(),
        ];
    }
}
