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
            Actions\Action::make('imprimir_pdf')
                ->label('Imprimir')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn($record) => route('estudiante.pdf', $record->id))
                ->openUrlInNewTab(),
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
                            TextEntry::make('lugarNacimiento.nombre_localidad')
                                ->label('Lugar de Nacimiento'),
                            TextEntry::make('numero_contacto_particular')
                                ->label('Número de Contacto Particular'),
                            TextEntry::make('numero_contacto_emergencia')
                                ->label('Número de Contacto de Emergencia'),
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
                            TextEntry::make('nombre_tecnicatura')
                                ->label('Nombre de la Tecnicatura'),
                        ]),
                        Grid::make(2)->schema([
                            TextEntry::make('aniodelacarrera.nombre')
                                ->label('Año de la Carrera'),
                            TextEntry::make('estado.nombre_estado')
                                ->label('Estado')
                                ->extraAttributes([
                                    'class' => 'uppercase font-bold',
                                ])
                                ->color(fn(string $state): string => match ($state) {
                                    'Activo' => 'success',
                                    'Dado de baja' => 'danger',
                                    'Licencia especial' => 'warning',
                                    default => 'gray',
                                }),
                        ]),
                        Grid::make(2)->schema([
                            TextEntry::make('anio_ingreso')
                                ->label('Año de Ingreso'),
                            TextEntry::make('anio_egreso')
                                ->label('Año de Egreso'),
                        ]),
                    ]),

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
                    ->visible(fn($record) => $record->domicilios->count() > 0)
                    ->collapsible(),

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
                    ->visible(fn($record) => $record->resoluciones->count() > 0)
                    ->collapsible(),

                Section::make('Arrestos')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('dias_arresto_anio_actual')
                                ->label('Días de arresto del año actual')
                                ->default(fn($record) => '<strong>' . \App\Models\Arrestos::getDiasAcumuladosPorAnio($record->id) . '</strong> días')
                                ->html()
                                ->color('warning'),
                            TextEntry::make('total_historico_arrestos')
                                ->label('Total histórico de arrestos')
                                ->default(fn($record) => '<strong>' . \App\Models\Arrestos::getTotalHistorico($record->id) . '</strong> días')
                                ->html()
                                ->color('info'),
                        ]),
                        TextEntry::make('limite_arrestos')
                            ->label('Límite anual')
                            ->default(fn($record) => 'Límite anual: <strong>' . \App\Models\Arrestos::LIMITE_DIAS_ARRESTO . '</strong> días')
                            ->html()
                            ->color('danger'),
                        RepeatableEntry::make('arrestos')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextEntry::make('fecha_de_arresto')
                                        ->label('Fecha')
                                        ->date(),
                                    TextEntry::make('dias_de_arresto')
                                        ->label('Días'),
                                    TextEntry::make('autoridad')
                                        ->label('Autoridad que sanciona')
                                        ->formatStateUsing(function ($record) {
                                            return $record->autoridad
                                                ? $record->autoridad->nombre_autoridad . ($record->autoridad->cargo_autoridad ? ' (' . $record->autoridad->cargo_autoridad . ')' : '')
                                                : 'No especificada';
                                        }),
                                    TextEntry::make('created_at')
                                        ->label('Fecha de Registro')
                                        ->dateTime(),
                                ]),
                                \Filament\Infolists\Components\Actions::make([
                                    \Filament\Infolists\Components\Actions\Action::make('view_arresto')
                                        ->label('Ver Detalles')
                                        ->icon('heroicon-o-eye')
                                        ->color('info')
                                        ->modalHeading('Detalles del Arresto')
                                        ->modalContent(function ($record) {
                                            return view('filament.resources.arrestos.modal-content', ['arresto' => $record]);
                                        })
                                        ->modalSubmitAction(false)
                                        ->modalCancelActionLabel('Cerrar'),
                                ]),
                            ])
                            ->columns(1),
                    ])
                    ->visible(fn($record) => $record->arrestos->count() > 0)
                    ->collapsible(),

                Section::make('Carpetas médicas')
                    ->schema([
                        RepeatableEntry::make('carpetasMedicas')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextEntry::make('fecha')->label('Fecha')->date(),
                                    TextEntry::make('dias')->label('Días'),
                                    TextEntry::make('autoridad')->label('Autoridad')
                                        ->formatStateUsing(function ($record) {
                                            return $record->autoridad
                                                ? $record->autoridad->nombre_autoridad . ($record->autoridad->cargo_autoridad ? ' (' . $record->autoridad->cargo_autoridad . ')' : '')
                                                : 'No especificada';
                                        }),
                                    TextEntry::make('descripcion')->label('Descripción')
                                ]),
                            ])
                            ->columns(1),
                    ])
                    ->visible(fn($record) => $record->carpetasMedicas->count() > 0)
                    ->collapsible(),

                Section::make('ART')
                    ->schema([
                        RepeatableEntry::make('arts')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextEntry::make('fecha')->label('Fecha')->date(),
                                    TextEntry::make('dias')->label('Días'),
                                    TextEntry::make('autoridad')->label('Autoridad')
                                        ->formatStateUsing(function ($record) {
                                            return $record->autoridad
                                                ? $record->autoridad->nombre_autoridad . ($record->autoridad->cargo_autoridad ? ' (' . $record->autoridad->cargo_autoridad . ')' : '')
                                                : 'No especificada';
                                        }),
                                    TextEntry::make('descripcion')->label('Descripción'),
                                ]),
                            ])
                            ->columns(1),
                    ])
                    ->visible(fn($record) => $record->arts->count() > 0)
                    ->collapsible(),
            ]);
    }
}
