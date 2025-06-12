<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Arrestos extends Model
{
    //
        public function faltas(): BelongsToMany
    {
        return $this->belongsToMany(Faltas::class);
    }
}
