<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estados;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $estados = [
            ['nombre_estado' => 'Postulante'],
            ['nombre_estado' => 'Activo'],
            ['nombre_estado' => 'Dado de baja'],
            ['nombre_estado' => 'Licencia especial'],
            ['nombre_estado' => 'Egresado'],
        ];
        foreach ($estados as $estado) {
            Estados::create($estado);
        }
    }
}
