<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\NotificacionEstudiante;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\EstudiantesResource;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Arrestos extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'arrestos';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Arresto fue {$eventName}";
    }

    protected static function booted()
    {
        static::created(function ($arresto) {
            $estudiante = $arresto->estudiante;
            if (!$estudiante) return;
            $diasAcumulados = $estudiante->arrestos()->sum('dias_de_arresto');
            if ($diasAcumulados >= 20) {
                // Evitar notificaciones duplicadas para el mismo exceso
                $yaNotificado = NotificacionEstudiante::where('estudiante_id', $estudiante->id)
                    ->where('mensaje', 'like', '%superó el límite de arrestos%')
                    ->where('leida', false)
                    ->exists();
                if (!$yaNotificado) {
                    $mensaje = "El {$estudiante->aniodelacarrera->nombre} {$estudiante->nombre_estudiante} {$estudiante->apellido_estudiante} superó el límite de arrestos con {$diasAcumulados} días acumulados.";
                    $notificacion = NotificacionEstudiante::create([
                        'estudiante_id' => $estudiante->id,
                        'mensaje' => $mensaje,
                        'leida' => false,
                    ]);
                    // Notificación Filament
                    Notification::make()
                        ->title('¡Límite de arrestos superado!')
                        ->body($mensaje)
                        ->warning()
                        ->actions([
                            Action::make('ver')
                                ->label('Ver Estudiante')
                                ->url(EstudiantesResource::getUrl('view', ['record' => $estudiante->id]), true)
                        ])
                        ->send();
                }
            }
        });
    }

    public function faltas(): BelongsToMany
    {
        return $this->belongsToMany(Faltas::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiantes::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('arrestos');
    }
}
