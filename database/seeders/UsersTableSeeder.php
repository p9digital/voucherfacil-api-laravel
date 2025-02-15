<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('users')->delete();

        DB::table('users')->insert(array(
            0 =>
            array(
                'id' => 1,
                'cliente_id' => NULL,
                'unidade_id' => NULL,
                'name' => 'Admin',
                'email' => 'admin@admin.com.br',
                'password' => '$2y$12$ToCbmnFY0KGZT/kZ7gZmsuRpZ.eN/XEaftDLJthOGHi1aRAbzimEu',
                'remember_token' => 'CxQxbahYNOwmRTWzs8yciRQv4JQGmQCYqIGVpUh5L66wb49KwnzqdS7leAth',
                'tipo' => 's',
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            1 =>
            array(
                'id' => 2,
                'cliente_id' => 1,
                'unidade_id' => NULL,
                'name' => 'Teste Testando',
                'email' => 'franq@teste.com',
                'password' => '$2y$10$l8ceILIfRcGfz5AQ.Upv0uHMFC5ptzFESB8DPg5YpNl3v0JQB2L0K',
                'remember_token' => 'vrTCqQSsxhHGvqh5uCyHDoGe8nqerW1q6HFb2GdDQuwjFEhZU9swz6NVazoM',
                'tipo' => 'a',
                'created_at' => '2018-06-04 18:59:09',
                'updated_at' => '2018-06-04 19:29:40',
                'status' => '1',
            ),
            2 =>
            array(
                'id' => 3,
                'cliente_id' => 1,
                'unidade_id' => 1,
                'name' => 'Alphaville',
                'email' => 'teste@teste.com',
                'password' => '$2y$10$y5/2lJqcXztojW11uS2iFuI65lfL2B11z4eUV0jUcnOJTULIFF0Va',
                'remember_token' => 'jTCPZOV72cP6iJXa2BFElTrbjXvUkxlTErfpQDKXiptv13sxt4HFWFskB2YK',
                'tipo' => 'f',
                'created_at' => '2018-06-04 19:36:23',
                'updated_at' => '2018-06-04 19:36:23',
                'status' => '1',
            ),
            3 =>
            array(
                'id' => 4,
                'cliente_id' => 1,
                'unidade_id' => 2,
                'name' => 'Brasilia',
                'email' => 'teste2@teste.com',
                'password' => '$2y$10$i3EQIKlJVoScWKr/olP/FuVjDNUiqtiaoswWSlMvB9V8Z9CxsZ5py',
                'remember_token' => NULL,
                'tipo' => 'f',
                'created_at' => '2018-06-04 19:56:26',
                'updated_at' => '2018-06-04 19:56:26',
                'status' => '1',
            ),
        ));
    }
}
