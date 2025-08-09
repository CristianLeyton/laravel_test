<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arts extends Model
{
    protected $fillable = [
        'estudiante_id',
        'fecha',
        'dias',
        'descripcion',
        'autoridad_id',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiantes::class);
    }

    public function autoridad(): BelongsTo
    {
        return $this->belongsTo(Autoridades::class, 'autoridad_id');
    }
}
