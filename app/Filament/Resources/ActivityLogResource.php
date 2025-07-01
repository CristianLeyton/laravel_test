<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Filament\Resources\ActivityLogResource\RelationManagers;
use App\Models\ActivityLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Auditoría';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?string $modelLabel = 'Log de Actividad';
    protected static ?string $pluralModelLabel = 'Auditoría';
    protected static ?int $navigationSort = 100;

    // Mapeo de nombres amigables para los campos
    protected static array $friendlyFieldNames = [
        // Estudiantes
        'nombre_estudiante' => 'Nombre',
        'apellido_estudiante' => 'Apellido',
        'dni_estudiante' => 'DNI',
        'cuil_estudiante' => 'CUIL',
        'fecha_nacimiento' => 'Fecha de nacimiento',
        'num_legajo' => 'N° de legajo',
        'foto_estudiante' => 'Foto',
        'aniodelacarrera_id' => 'Año de la carrera',
        'estado_id' => 'Estado',
        'observaciones' => 'Observaciones',
        // Arrestos
        'dias_de_arresto' => 'Días de arresto',
        'fecha_inicio' => 'Fecha de inicio',
        'fecha_fin' => 'Fecha de fin',
        'motivo' => 'Motivo',
        'estudiante_id' => 'Estudiante',
        // Resoluciones
        'numero_de_resolucion' => 'N° de resolución',
        'foto' => 'Foto',
        // Comunes
        'id' => 'ID',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
        'deleted_at' => 'Eliminado el',
    ];

    public static function form(Form $form): Form
    {
        return $form->schema([]); // Solo lectura
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Acción')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        $modelo = class_basename($record->subject_type ?? '');
                        $modelo = match ($modelo) {
                            'Estudiantes' => 'Estudiante',
                            'Arrestos' => 'Arresto',
                            'Resoluciones' => 'Resolución',
                            default => $modelo,
                        };
                        if (str_contains($state, 'created')) {
                            return "$modelo fue creado";
                        }
                        if (str_contains($state, 'updated')) {
                            return "$modelo fue actualizado";
                        }
                        if (str_contains($state, 'deleted')) {
                            return "$modelo fue eliminado";
                        }
                        return ucfirst($state);
                    }),
                Tables\Columns\TextColumn::make('subject_id')
                    ->label('Estudiante')
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->formatStateUsing(function ($state, $record) {
                        $model = $record->subject_type;
                        $id = $record->subject_id;
                        if (!$model || !$id) return '-';
                        if (in_array(class_basename($model), ['Estudiantes', 'Arrestos', 'Resoluciones'])) {
                            $estudiante = null;
                            $props = $record->properties;
                            if (is_string($props)) {
                                $props = json_decode($props, true);
                            }
                            if (class_basename($model) === 'Estudiantes') {
                                $estudiante = \App\Models\Estudiantes::find($id);
                                if (!$estudiante && isset($props['old'])) {
                                    $nombre = trim(($props['old']['nombre_estudiante'] ?? '') . ' ' . ($props['old']['apellido_estudiante'] ?? ''));
                                    if ($nombre) {
                                        return "<span>{$nombre}</span>";
                                    }
                                }
                            } elseif (class_basename($model) === 'Arrestos') {
                                $arresto = \App\Models\Arrestos::find($id);
                                if ($arresto && $arresto->estudiante) {
                                    $estudiante = $arresto->estudiante;
                                } else {
                                    $estudianteId = $props['old']['estudiante_id'] ?? $props['attributes']['estudiante_id'] ?? null;
                                    if ($estudianteId) {
                                        $estudiante = \App\Models\Estudiantes::find($estudianteId);
                                        if (!$estudiante) {
                                            return "<span>{$estudianteId} (ID estudiante)</span>";
                                        }
                                    }
                                }
                            } elseif (class_basename($model) === 'Resoluciones') {
                                $resolucion = \App\Models\Resoluciones::find($id);
                                if ($resolucion && $resolucion->estudiante) {
                                    $estudiante = $resolucion->estudiante;
                                } else {
                                    $estudianteId = $props['old']['estudiante_id'] ?? $props['attributes']['estudiante_id'] ?? null;
                                    if ($estudianteId) {
                                        $estudiante = \App\Models\Estudiantes::find($estudianteId);
                                        if (!$estudiante) {
                                            return "<span>{$estudianteId} (ID estudiante)</span>";
                                        }
                                    }
                                }
                            }
                            if ($estudiante) {
                                $nombre = $estudiante->nombre_estudiante . ' ' . $estudiante->apellido_estudiante;
                                $url = \App\Filament\Resources\EstudiantesResource::getUrl('view', ['record' => $estudiante->id]);
                                return "<a href='{$url}' target='_blank' style='text-decoration:none;'>{$nombre}</a>";
                            }
                        }
                        return '-';
                    })
                    ->html(),
                ViewColumn::make('properties')
                    ->label('Cambios')
                    ->view('components.filament.activity-log-properties')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Módulo')
                    ->options(fn() => Activity::query()->distinct()->pluck('log_name', 'log_name')->filter()),
                Tables\Filters\SelectFilter::make('description')
                    ->label('Acción')
                    ->options(fn() => Activity::query()->distinct()->pluck('description', 'description')->filter()),
                Tables\Filters\SelectFilter::make('causer_id')
                    ->label('Usuario')
                    ->options(fn() => Activity::with('causer')->get()->pluck('causer.name', 'causer_id')->filter()),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }

    // Nueva función para renderizar tabla de updates
    private static function renderUpdateChangesTable(array $old, array $new): string
    {
        $friendly = self::$friendlyFieldNames;
        $getLabel = fn($key) => $friendly[$key] ?? ucfirst(str_replace('_', ' ', $key));
        $rows = '';
        $allKeys = array_unique(array_merge(array_keys($old), array_keys($new)));
        foreach ($allKeys as $key) {
            $oldVal = $old[$key] ?? '-';
            $newVal = $new[$key] ?? '-';
            $label = $getLabel($key);
            $rows .= "<tr><td><b>{$label}</b></td><td style='color:#b91c1c'>{$oldVal}</td><td style='color:#15803d'>{$newVal}</td></tr>";
        }
        if ($rows) {
            return "<table style='font-size:12px;'><thead><tr><th>Campo</th><th>Antes</th><th>Después</th></tr></thead><tbody>{$rows}</tbody></table>";
        } else {
            // Debug visual: mostrar contenido crudo
            ob_start();
            echo '<pre>$old: ';
            print_r($old);
            echo "\n$new: ";
            print_r($new);
            echo '</pre>';
            return ob_get_clean();
        }
    }
}
