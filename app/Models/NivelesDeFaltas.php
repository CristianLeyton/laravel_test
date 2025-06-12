<?php

namespace App\Models;

use Illuminate\Database\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class NivelesDeFaltas extends Model
{
    //
    public function faltas(): HasMany
    {
        return $this->hasMany(Faltas::class);
    }

}
