<?php

namespace App\Filament\Resources\EstudiantesResource\Pages;

use App\Filament\Resources\EstudiantesResource;
use Dom\Text;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Grid;

class ViewEstudiante extends ViewRecord
{
    protected static string $resource = EstudiantesResource::class;

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
                Section::make('Información Personal')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('nombre_estudiante')
                                ->label('Nombre'),
                            TextEntry::make('apellido_estudiante')
                                ->label('Apellido'),
                            TextEntry::make('dni_estudiante')
                                ->label('DNI'),
                            TextEntry::make('cuil_estudiante')
                                ->label('CUIL'),
                            TextEntry::make('fecha_nacimiento')
                                ->label('Fecha de Nacimiento')
                                ->date(),
                            TextEntry::make('num_legajo')
                                ->label('Número de Legajo'),
                        ]),
                        Grid::make(2)->schema([
                        ImageEntry::make('foto_estudiante')
                            ->label('Foto')
                            ->circular()
                            ->visible(fn($record) => $record->foto_estudiante)
                            ->url(fn($record) => $record->foto_estudiante ? asset('storage/' . $record->foto_estudiante) : null),
                        TextEntry::make('observaciones')
                            ->label('Observaciones')
                            ->visible(fn($record) => $record->observaciones),
                            ]),
                    ]),

                Section::make('Información Académica')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('aniodelacarrera.nombre')
                                ->label('Año de la Carrera'),
                            TextEntry::make('estado.nombre_estado')
                                ->label('Estado'),
                        ]),
                    ]),

                Section::make('Resoluciones')
                    ->schema([
                        RepeatableEntry::make('resoluciones')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextEntry::make('numero_de_resolucion')
                                        ->label('Número de Resolución'),
                                    TextEntry::make('created_at')
                                        ->label('Fecha de Registro')
                                        ->dateTime(),
                                ]),
                                \Filament\Infolists\Components\Actions::make([
                                    \Filament\Infolists\Components\Actions\Action::make('view_resolucion')
                                        ->label('Ver Detalles')
                                        ->icon('heroicon-o-eye')
                                        ->color('info')
                                        ->modalHeading('Detalles de la Resolución')
                                        ->modalContent(function ($record) {
                                            return view('filament.resources.resoluciones.modal-content', ['resolucion' => $record]);
                                        })
                                        ->modalSubmitAction(false)
                                        ->modalCancelActionLabel('Cerrar'),
                                ]),
                            ])
                            ->columns(1),
                    ])
                    ->collapsible(),

                Section::make('Domicilios')
                    ->schema([
                        RepeatableEntry::make('domicilios')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextEntry::make('tipoDeDomicilio.nombre_tipo_domicilio')
                                        ->label('Tipo'),
                                        TextEntry::make('descripcion_domicilio')
                                            ->label('Descripción'),
                                            TextEntry::make('direccion_estudiante')
                                                ->label('Dirección'),
                                    TextEntry::make('localidad.nombre_localidad')
                                        ->label('Localidad'),
                                ]),
                            ])
                            ->columns(1),
                    ])
                    ->collapsible(),

                Section::make('Arrestos')
                    ->schema([
                        RepeatableEntry::make('arrestos')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextEntry::make('fecha_de_arresto')
                                        ->label('Fecha')
                                        ->date(),
                                    TextEntry::make('dias_de_arresto')
                                        ->label('Días'),
                                    TextEntry::make('created_at')
                                        ->label('Fecha de Registro')
                                        ->dateTime(),
                                ]),
                            ])
                            ->columns(1),
                    ])
                    ->collapsible(),
            ]);
    }
}
