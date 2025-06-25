<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aniodelacarrera extends Model
{
    protected $table = 'aniodelacarreras';

    protected $fillable = [
        'nombre'
    ];

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiantes::class, 'aniodelacarrera_id');
    }
}
