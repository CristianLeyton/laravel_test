<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resoluciones extends Model
{
    protected $fillable = [
        'numero_de_resolucion',
        'foto',
        'estudiante_id'
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiantes::class, 'estudiante_id');
    }
}
