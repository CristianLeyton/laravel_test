<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estados extends Model
{
    protected $fillable = [
        'nombre_estado'
    ];

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiantes::class, 'estado_id');
    }
}
