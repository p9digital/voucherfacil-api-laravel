<?php

namespace Database\Seeders;

// use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(CidadesTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(RegioesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        // $this->call(ClientesTableSeeder::class);
        // $this->call(FotosTableSeeder::class);
        // $this->call(PeriodosTableSeeder::class);
        // $this->call(PromocoesTableSeeder::class);
        // $this->call(PromocoesUnidadesTableSeeder::class);
        // $this->call(RegioesTableSeeder::class);
        // $this->call(UnidadesTableSeeder::class);
    }
}
