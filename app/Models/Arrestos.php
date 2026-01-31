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
    public const ALERTA_CERCA_LIMITE = 20; //Dias para alerta de proximidad al limite

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

            // Alerta cuando está cerca del límite (20 días)
            if ($diasAcumulados >= self::ALERTA_CERCA_LIMITE && $diasAcumulados < self::LIMITE_DIAS_ARRESTO) {
                self::enviarAlertaCercaLimite($estudiante, $diasAcumulados, $anioActual);
            }

            // Alerta cuando supera el límite (30 días)
            if ($diasAcumulados >= self::LIMITE_DIAS_ARRESTO) {
                self::enviarAlertaLimiteSuperado($estudiante, $diasAcumulados, $anioActual);
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

    /**
     * Obtiene el estado de alertas de arrestos para un estudiante en un año específico
     */
    public static function getEstadoAlertas($estudianteId, $anio = null)
    {
        $anio = $anio ?? now()->year;
        $diasAcumulados = self::getDiasAcumuladosPorAnio($estudianteId, $anio);

        if ($diasAcumulados >= self::LIMITE_DIAS_ARRESTO) {
            return [
                'estado' => 'limite_superado',
                'dias_acumulados' => $diasAcumulados,
                'dias_restantes' => 0,
                'nivel_alerta' => 'danger',
                'mensaje' => 'Límite superado',
                'porcentaje' => 100
            ];
        } elseif ($diasAcumulados >= self::ALERTA_CERCA_LIMITE) {
            $diasRestantes = self::LIMITE_DIAS_ARRESTO - $diasAcumulados;
            $porcentaje = ($diasAcumulados / self::LIMITE_DIAS_ARRESTO) * 100;

            return [
                'estado' => 'cerca_limite',
                'dias_acumulados' => $diasAcumulados,
                'dias_restantes' => $diasRestantes,
                'nivel_alerta' => 'warning',
                'mensaje' => 'Cerca del límite',
                'porcentaje' => round($porcentaje, 1)
            ];
        } else {
            $porcentaje = ($diasAcumulados / self::LIMITE_DIAS_ARRESTO) * 100;

            return [
                'estado' => 'normal',
                'dias_acumulados' => $diasAcumulados,
                'dias_restantes' => self::LIMITE_DIAS_ARRESTO - $diasAcumulados,
                'nivel_alerta' => 'success',
                'mensaje' => 'Normal',
                'porcentaje' => round($porcentaje, 1)
            ];
        }
    }

    /**
     * Envía alerta cuando el estudiante está cerca del límite de arrestos
     */
    private static function enviarAlertaCercaLimite($estudiante, $diasAcumulados, $anioActual)
    {
        // Evitar notificaciones duplicadas para la misma alerta en el año actual
        $yaNotificado = NotificacionEstudiante::where('estudiante_id', $estudiante->id)
            ->where('mensaje', 'like', "%está cerca del límite de arrestos del año {$anioActual}%")
            ->where('leida', false)
            ->exists();

        if (!$yaNotificado) {
            $mensaje = "El {$estudiante->aniodelacarrera->nombre} {$estudiante->nombre_estudiante} {$estudiante->apellido_estudiante} está cerca del límite de arrestos del año {$anioActual} con {$diasAcumulados} días acumulados. Límite: " . self::LIMITE_DIAS_ARRESTO . " días.";

            $notificacion = NotificacionEstudiante::create([
                'estudiante_id' => $estudiante->id,
                'mensaje' => $mensaje,
                'leida' => false,
            ]);

            // Notificación Filament
            Notification::make()
                ->title('⚠️ Alerta: Cerca del límite de arrestos')
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

    /**
     * Envía alerta cuando el estudiante supera el límite de arrestos
     */
    private static function enviarAlertaLimiteSuperado($estudiante, $diasAcumulados, $anioActual)
    {
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
                ->title('🚨 ¡Límite de arrestos superado!')
                ->body($mensaje)
                ->danger()
                ->actions([
                    Action::make('ver')
                        ->label('Ver Estudiante')
                        ->url(EstudiantesResource::getUrl('view', ['record' => $estudiante->id]), true)
                ])
                ->send();
        }
    }
}
