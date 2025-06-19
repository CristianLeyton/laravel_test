<?php

namespace App\Filament\Resources\ResolucionesResource\Pages;

use App\Filament\Resources\ResolucionesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;

class ViewResolucion extends ViewRecord
{
    protected static string $resource = ResolucionesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Información de la Resolución')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('numero_de_resolucion')
                                ->label('Número de Resolución')
                                ->size(TextEntry\TextEntrySize::Large),
                            TextEntry::make('created_at')
                                ->label('Fecha de Creación')
                                ->dateTime(),
                        ]),
                    ]),

                Section::make('Información del Estudiante')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('estudiante.nombre_estudiante')
                                ->label('Nombre'),
                            TextEntry::make('estudiante.apellido_estudiante')
                                ->label('Apellido'),
                            TextEntry::make('estudiante.dni_estudiante')
                                ->label('DNI'),
                            TextEntry::make('estudiante.num_legajo')
                                ->label('Número de Legajo'),
                            TextEntry::make('estudiante.aniodelacarrera.nombre')
                                ->label('Año de la Carrera'),
                            TextEntry::make('estudiante.estado.nombre_estado')
                                ->label('Estado'),
                        ]),
                    ]),

                Section::make('Documento de la Resolución')
                    ->schema([
                        ImageEntry::make('foto')
                            ->label('Foto de la Resolución')
                            ->visible(fn($record) => $record->foto),
                    ])
                    ->collapsible(),
            ]);
    }
}
