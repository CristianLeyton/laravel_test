<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Resoluciones extends Model
{
    protected $fillable = [
        'numero_de_resolucion'
    ];

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(Estudiantes::class, 'estudiante_resolucion');
    }
}
