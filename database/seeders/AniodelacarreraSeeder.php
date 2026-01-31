<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aniodelacarrera;

class AniodelacarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $anios = [
            ['nombre' => 'Postulante'],
            ['nombre' => 'Cadete de 1º año'],
            ['nombre' => 'Cadete de 2º año'],
            ['nombre' => 'Cadete de 3º año'],
        ];
        foreach ($anios as $anio) {
            Aniodelacarrera::create($anio);
        }
    }
}

