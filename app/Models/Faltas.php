<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Faltas extends Model
{
    //
        public function nivelesDeFaltas(): BelongsTo
    {
        return $this->belongsTo(NivelesDeFaltas::class);
    }
    public function arrestos(): BelongsToMany
    {
        return $this->belongsToMany(Arrestos::class);
    }
}
