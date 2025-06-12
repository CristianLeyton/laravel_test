<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Localidades;

class LocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $localidades = [
    ['nombre_localidad' => 'Aguas Blancas'],
    ['nombre_localidad' => 'Aguaray'],
    ['nombre_localidad' => 'Angastaco'],
    ['nombre_localidad' => 'Animaná'],
    ['nombre_localidad' => 'Cachi'],
    ['nombre_localidad' => 'Cafayate'],
    ['nombre_localidad' => 'Campo Quijano'],
    ['nombre_localidad' => 'Campo Santo'],
    ['nombre_localidad' => 'Capitán Juan Pagé'],
    ['nombre_localidad' => 'Cerrillos'],
    ['nombre_localidad' => 'Chicoana'],
    ['nombre_localidad' => 'Colonia Santa Rosa'],
    ['nombre_localidad' => 'Coronel Juan Solá'],
    ['nombre_localidad' => 'Coronel Moldes'],
    ['nombre_localidad' => 'El Bordo'],
    ['nombre_localidad' => 'El Carril'],
    ['nombre_localidad' => 'El Galpón'],
    ['nombre_localidad' => 'El Potrero'],
    ['nombre_localidad' => 'El Quebrachal'],
    ['nombre_localidad' => 'El Tala'],
    ['nombre_localidad' => 'Embarcación'],
    ['nombre_localidad' => 'General Ballivián'],
    ['nombre_localidad' => 'General Güemes'],
    ['nombre_localidad' => 'General Mosconi'],
    ['nombre_localidad' => 'Guachipas'],
    ['nombre_localidad' => 'Hipólito Yrigoyen'],
    ['nombre_localidad' => 'Iruya'],
    ['nombre_localidad' => 'Isla de Cañas'],
    ['nombre_localidad' => 'Joaquín V. González'],
    ['nombre_localidad' => 'La Caldera'],
    ['nombre_localidad' => 'La Candelaria'],
    ['nombre_localidad' => 'La Merced'],
    ['nombre_localidad' => 'La Poma'],
    ['nombre_localidad' => 'La Viña'],
    ['nombre_localidad' => 'Las Lajitas'],
    ['nombre_localidad' => 'Los Toldos'],
    ['nombre_localidad' => 'Metán'],
    ['nombre_localidad' => 'Molinos'],
    ['nombre_localidad' => 'Nazareno'],
    ['nombre_localidad' => 'Orán'],
    ['nombre_localidad' => 'Payogasta'],
    ['nombre_localidad' => 'Pichanal'],
    ['nombre_localidad' => 'Río Piedras'],
    ['nombre_localidad' => 'Rivadavia'],
    ['nombre_localidad' => 'Rosario de la Frontera'],
    ['nombre_localidad' => 'Rosario de Lerma'],
    ['nombre_localidad' => 'Salta'],
    ['nombre_localidad' => 'San Antonio de los Cobres'],
    ['nombre_localidad' => 'San Carlos'],
    ['nombre_localidad' => 'San José de Metán'],
    ['nombre_localidad' => 'San Ramón de la Nueva Orán'],
    ['nombre_localidad' => 'Santa Victoria Este'],
    ['nombre_localidad' => 'Santa Victoria Oeste'],
    ['nombre_localidad' => 'Seclantás'],
    ['nombre_localidad' => 'Tartagal'],
    ['nombre_localidad' => 'Tolombón'],
    ['nombre_localidad' => 'Urundel'],
    ['nombre_localidad' => 'Vaqueros'],
    ['nombre_localidad' => 'Villa San Lorenzo']
];

        foreach ($localidades as $localidad) {
            Localidades::create($localidad);
        }
    }
}
