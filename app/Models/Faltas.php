<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faltas extends Model
{
    //
    public function nivelesDefaltas(): BelongsTo
    {
        return $this->belongsTo(NivelesDeFaltas::class);
    }
}
