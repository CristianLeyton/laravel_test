<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelesDeFaltas extends Model
{
    //
        public function faltas(): HasMany
    {
        return $this->hasMany(Faltas::class);
    }
}
