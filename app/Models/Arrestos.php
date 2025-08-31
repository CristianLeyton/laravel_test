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
use Illuminate\Support\Facades\DB;

class Arrestos extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'arrestos';
    public const LIMITE_DIAS_ARRESTO = 30; //Dias limite de arrestos

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Arresto fue {$eventName}";
    }

    protected static function booted()
    {
        static::created(function ($arresto) {
            $estudiante = $arresto->estudiante;
            if (!$estudiante) return;

            // Calcular días acumulados solo del año actual
            $anioActual = now()->year;
            $diasAcumulados = self::getDiasAcumuladosPorAnio($estudiante->id, $anioActual);

            if ($diasAcumulados >= self::LIMITE_DIAS_ARRESTO) {
                // Evitar notificaciones duplicadas para el mismo exceso en el año actual
                $yaNotificado = NotificacionEstudiante::where('estudiante_id', $estudiante->id)
                    ->where('mensaje', 'like', "%superó el límite de arrestos del año {$anioActual}%")
                    ->where('leida', false)
                    ->exists();

                if (!$yaNotificado) {
                    $mensaje = "El {$estudiante->aniodelacarrera->nombre} {$estudiante->nombre_estudiante} {$estudiante->apellido_estudiante} superó el límite de arrestos del año {$anioActual} con {$diasAcumulados} días acumulados.";
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

    public function autoridad(): BelongsTo
    {
        return $this->belongsTo(Autoridades::class, 'autoridad_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('arrestos');
    }

    /**
     * Obtiene los días acumulados de arrestos para un año específico
     */
    public static function getDiasAcumuladosPorAnio($estudianteId, $anio = null)
    {
        $anio = $anio ?? now()->year;

        // Usar consulta SQL directa para SQLite sin parámetros preparados
        $sql = "SELECT SUM(dias_de_arresto) as total FROM arrestos WHERE estudiante_id = {$estudianteId} AND strftime('%Y', fecha_de_arresto) = '{$anio}'";
        $resultado = DB::select($sql);

        return $resultado[0]->total ?? 0;
    }

    /**
     * Obtiene el total histórico de días de arrestos
     */
    public static function getTotalHistorico($estudianteId)
    {
        return self::where('estudiante_id', $estudianteId)
            ->sum('dias_de_arresto');
    }

    /**
     * Verifica si un estudiante superó el límite en un año específico
     */
    public static function superaLimiteEnAnio($estudianteId, $anio = null)
    {
        $anio = $anio ?? now()->year;
        $diasAcumulados = self::getDiasAcumuladosPorAnio($estudianteId, $anio);
        return $diasAcumulados >= self::LIMITE_DIAS_ARRESTO;
    }

    /**
     * Obtiene el total de días de arrestos de todos los estudiantes en un año específico
     */
    public static function getTotalDiasPorAnio($anio = null)
    {
        $anio = $anio ?? now()->year;

        // Usar consulta SQL directa para SQLite sin parámetros preparados
        $sql = "SELECT SUM(dias_de_arresto) as total FROM arrestos WHERE strftime('%Y', fecha_de_arresto) = '{$anio}'";
        $resultado = DB::select($sql);

        return $resultado[0]->total ?? 0;
    }
}
