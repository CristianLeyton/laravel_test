<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NivelesDeFaltas;

class NivelesDeFaltaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $niveles = [
    ['nombre_de_nivel' => 'Leve'],
    ['nombre_de_nivel' => 'Grave'],
    ['nombre_de_nivel' => 'Muy Grave'],
        ];
        foreach ($niveles as $nivel) {
            NivelesDeFaltas::create($nivel);
        }
    }
}
