<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

            User::factory()->create([
                        'name' => 'Ordoñez Oriana',
            'email' => 'ordoñezoriana@mail.com',
            'password' => bcrypt('ordoñez'),
        ]);

        User::factory()->create([
            'name' => 'Lopez Brisa',
            'email' => 'lopezbrisa@mail.com',
            'password' => bcrypt('lopez'),
        ]);

        User::factory()->create([
            'name' => 'Barrionuevo Cecilia',
            'email' => 'barrionuevocecilia@mail.com',
            'password' => bcrypt('barrionuevo'),
        ]);

        User::factory()->create([
            'name' => 'Flores Abigail',
            'email' => 'floresabigail@mail.com',
            'password' => bcrypt('flores'),
        ]);

        User::factory()->create([
            'name' => 'Aramayo Antonella',
            'email' => 'aramayoantonella@mail.com',
            'password' => bcrypt('aramayo'),
        ]);

        User::factory()->create([
            'name' => 'Paz Camila',
            'email' => 'pazcamila@mail.com',
            'password' => bcrypt('paz'),
        ]);

        User::factory()->create([
            'name' => 'Emilia Cancinos',
            'email' => 'emiliacancinos@mail.com',
            'password' => bcrypt('cancinos'),
        ]);

        $this->call(LocalidadesSeeder::class);
        $this->call(NivelesDeFaltaSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(AniodelacarreraSeeder::class);
        $this->call(TiposDeDomiciliosSeeder::class);
        $this->call(FaltasSeeder::class);
    }
}
