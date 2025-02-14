<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('clientes')->delete();

        DB::table('clientes')->insert(array(
            0 =>
            array(
                'id' => 1,
                'razaoSocial' => 'L\'Entrecôte de Paris',
                'nomeFantasia' => 'L\'Entrecôte de Paris',
                'path' => 'lentrecote-de-paris',
                'logo' => 'logo-lentrecote-branco.png',
                'created_at' => '2018-03-08 14:10:48',
                'updated_at' => NULL,
                'status' => '1',
            ),
        ));
    }
}
