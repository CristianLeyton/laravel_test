<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Estudiantes extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'estudiantes';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Estudiante fue {$eventName}";
    }

    protected $fillable = [
        'nombre_estudiante',
        'apellido_estudiante',
        'dni_estudiante',
        'cuil_estudiante',
        'fecha_nacimiento',
        'num_legajo',
        'foto_estudiante',
        'aniodelacarrera_id',
        'estado_id',
        'lugar_nacimiento_id',
        'numero_contacto_particular',
        'numero_contacto_emergencia',
        'observaciones'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function aniodelacarrera(): BelongsTo
    {
        return $this->belongsTo(Aniodelacarrera::class);
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estados::class);
    }

    public function resoluciones(): HasMany
    {
        return $this->hasMany(Resoluciones::class, 'estudiante_id');
    }

    public function domicilios(): HasMany
    {
        return $this->hasMany(Domicilios::class);
    }

    public function arrestos(): HasMany
    {
        return $this->hasMany(Arrestos::class, 'estudiante_id');
    }

    public function carpetasMedicas(): HasMany
    {
        return $this->hasMany(CarpetasMedicas::class, 'estudiante_id');
    }

    public function arts(): HasMany
    {
        return $this->hasMany(Arts::class, 'estudiante_id');
    }

    public function lugarNacimiento(): BelongsTo
    {
        return $this->belongsTo(Localidades::class, 'lugar_nacimiento_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('estudiantes');
    }
}
