<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faltas;

class FaltasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //Niveles de faltas
    //1. Leve
    //2. Media
    //3. Grave

    public function run(): void
    {
        //
        $faltas = [
            ['nombre_de_falta' => 'Falta numero 1', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Falta numero 2', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Falta numero 3', 'niveles_de_faltas_id' => 3],
            ['nombre_de_falta' => 'Falta numero 4', 'niveles_de_faltas_id' => 1],
            ['nombre_de_falta' => 'Falta numero 5', 'niveles_de_faltas_id' => 2],
            ['nombre_de_falta' => 'Falta numero 6', 'niveles_de_faltas_id' => 3]
        ];

        foreach ($faltas as $falta) {
            Faltas::create($falta);
        }
    }
}
