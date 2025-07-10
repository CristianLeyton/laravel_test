<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class TiposDeDomicilios extends Model
{
    protected $fillable = [
        'nombre_tipo_domicilio'
    ];

    //
    public function domicilios(): HasMany
    {
        return $this->hasMany(Domicilios::class, 'tipos_de_domicilios_id');
    }
}
