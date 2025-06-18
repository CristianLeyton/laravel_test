<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Localidades extends Model
{
    protected $fillable = [
        'nombre_localidad'
    ];

    public function domicilios(): HasMany
    {
        return $this->hasMany(Domicilios::class, 'localidades_id');
    }

    public function domiciliosEstudiantes(): HasMany
    {
        return $this->hasMany(Domicilios::class);
    }
}
