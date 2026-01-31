<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autoridades extends Model
{
    protected $fillable = [
        'nombre_autoridad',
        'cargo_autoridad',
    ];
}
