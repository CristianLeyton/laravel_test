<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionEstudiante extends Model
{
    protected $fillable = [
        'estudiante_id',
        'mensaje',
        'leida',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiantes::class, 'estudiante_id');
    }
}
