<?php

namespace App\Filament\Resources\EstudiantesResource\Pages;

use App\Filament\Resources\EstudiantesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEstudiantes extends ListRecords
{
    protected static string $resource = EstudiantesResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            // Default tab al cargar
            // 'Activo' será la pestaña por defecto
            'Activos' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas('estado', fn($q) => $q->where('nombre_estado', 'Activo'))
                ),

            '1º año' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('aniodelacarrera', fn($q) => $q->where('nombre', 'Cadete de 1º año'))
                        ->whereHas('estado', fn($q) => $q->where('nombre_estado', 'Activo'))
                ),
            '2º año' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('aniodelacarrera', fn($q) => $q->where('nombre', 'Cadete de 2º año'))
                        ->whereHas('estado', fn($q) => $q->where('nombre_estado', 'Activo'))
                ),
            '3º año' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->whereHas('aniodelacarrera', fn($q) => $q->where('nombre', 'Cadete de 3º año'))
                        ->whereHas('estado', fn($q) => $q->where('nombre_estado', 'Activo'))
                ),
            'Bajas' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas('estado', fn($q) => $q->where('nombre_estado', 'Dado de baja'))
                ),
            'Egresados' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereHas('estado', fn($q) => $q->where('nombre_estado', 'Egresado'))
                ),

            'Todos' => Tab::make(),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'Activos';
    }
}
