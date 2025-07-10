<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TiposDeDomicilios;


class TiposDeDomiciliosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tipos = [
    ['nombre_tipo_domicilio' => 'Legal'],
    ['nombre_tipo_domicilio' => 'Real'],
        ];
        foreach ($tipos as $tipo) {
            TiposDeDomicilios::create($tipo);
        }
    }
}
