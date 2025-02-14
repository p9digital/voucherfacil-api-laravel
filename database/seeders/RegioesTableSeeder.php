<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegioesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('regioes')->delete();

        DB::table('regioes')->insert(array(
            0 =>
            array(
                'id' => 1,
                'nome' => 'Norte',
            ),
            1 =>
            array(
                'id' => 2,
                'nome' => 'Nordeste',
            ),
            2 =>
            array(
                'id' => 3,
                'nome' => 'Sudeste',
            ),
            3 =>
            array(
                'id' => 4,
                'nome' => 'Sul',
            ),
            4 =>
            array(
                'id' => 5,
                'nome' => 'Centro-Oeste',
            ),
        ));
    }
}
