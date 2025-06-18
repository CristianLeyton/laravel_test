<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Domicilios extends Model
{
    protected $fillable = [
        'estudiantes_id',
        'tipos_de_domicilios_id',
        'descripcion_domicilio',
        'direccion_estudiante',
        'localidades_id'
    ];

    public function localidades(): BelongsTo
    {
        return $this->belongsTo(Localidades::class);
    }

    public function tiposDeDomicilios(): BelongsTo
    {
        return $this->belongsTo(TiposDeDomicilios::class);
    }

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiantes::class, 'estudiantes_id');
    }

    public function tipoDeDomicilio(): BelongsTo
    {
        return $this->belongsTo(TiposDeDomicilios::class, 'tipos_de_domicilios_id');
    }

    public function localidad(): BelongsTo
    {
        return $this->belongsTo(Localidades::class, 'localidades_id');
    }
}
