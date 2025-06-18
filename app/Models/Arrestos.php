<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arrestos extends Model
{
    //
        public function faltas(): BelongsToMany
    {
        return $this->belongsToMany(Faltas::class);
    }

        public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiantes::class);
    }
}
