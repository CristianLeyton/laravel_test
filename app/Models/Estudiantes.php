<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiantes extends Model
{
    protected $fillable = [
        'nombre_estudiante',
        'apellido_estudiante',
        'dni_estudiante',
        'cuil_estudiante',
        'fecha_nacimiento',
        'num_legajo',
        'foto_estudiante',
        'aniodelacarrera_id',
        'estado_id'
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

    public function resoluciones(): BelongsToMany
    {
        return $this->belongsToMany(Resoluciones::class, 'estudiante_resolucion');
    }

    public function domicilios(): HasMany
    {
        return $this->hasMany(Domicilios::class);
    }

    public function arrestos(): HasMany
    {
        return $this->hasMany(Arrestos::class, 'estudiante_id');
    }
}
