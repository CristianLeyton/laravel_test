<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resoluciones;

class ResolucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $resoluciones = [
    ['numero_de_resolucion' => '120/2025'],
    ['numero_de_resolucion' => '110/2025'],
        ];
        foreach ($resoluciones as $resolucion) {
            Resoluciones::create($resolucion);
        }
    }
}
