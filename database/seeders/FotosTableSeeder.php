<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FotosTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('fotos')->delete();

        DB::table('fotos')->insert(array(
            0 =>
            array(
                'id' => 1,
                'promocao_id' => 1,
                'arquivo' => 'pratos.jpg',
                'ordem' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            1 =>
            array(
                'id' => 2,
                'promocao_id' => 1,
                'arquivo' => 'patino.jpg',
                'ordem' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            2 =>
            array(
                'id' => 3,
                'promocao_id' => 1,
                'arquivo' => 'mousse.jpg',
                'ordem' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            3 =>
            array(
                'id' => 4,
                'promocao_id' => 1,
                'arquivo' => 'prato.jpg',
                'ordem' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            4 =>
            array(
                'id' => 5,
                'promocao_id' => 1,
                'arquivo' => 'prato2.jpg',
                'ordem' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            5 =>
            array(
                'id' => 6,
                'promocao_id' => 1,
                'arquivo' => 'pudim.jpg',
                'ordem' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            6 =>
            array(
                'id' => 7,
                'promocao_id' => 2,
                'arquivo' => 'promocao2-geral.jpg',
                'ordem' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            7 =>
            array(
                'id' => 8,
                'promocao_id' => 2,
                'arquivo' => 'promocao2-entrecote.jpg',
                'ordem' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            8 =>
            array(
                'id' => 9,
                'promocao_id' => 2,
                'arquivo' => 'promocao2-salada.jpg',
                'ordem' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            9 =>
            array(
                'id' => 10,
                'promocao_id' => 2,
                'arquivo' => 'promocao2-petit-fromage.jpg',
                'ordem' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            10 =>
            array(
                'id' => 11,
                'promocao_id' => 2,
                'arquivo' => 'promocao2-sobremesa.jpg',
                'ordem' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            11 =>
            array(
                'id' => 12,
                'promocao_id' => 2,
                'arquivo' => 'promocao2-sobremesa2.jpg',
                'ordem' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            12 =>
            array(
                'id' => 13,
                'promocao_id' => 3,
                'arquivo' => 'promocao3-entrecote-vinho.jpg',
                'ordem' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            13 =>
            array(
                'id' => 14,
                'promocao_id' => 3,
                'arquivo' => 'patino.jpg',
                'ordem' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            14 =>
            array(
                'id' => 15,
                'promocao_id' => 3,
                'arquivo' => 'prato.jpg',
                'ordem' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            15 =>
            array(
                'id' => 16,
                'promocao_id' => 3,
                'arquivo' => 'prato2.jpg',
                'ordem' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            16 =>
            array(
                'id' => 17,
                'promocao_id' => 4,
                'arquivo' => 'promocao4-entrecote.jpg',
                'ordem' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            17 =>
            array(
                'id' => 18,
                'promocao_id' => 4,
                'arquivo' => 'patino.jpg',
                'ordem' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            18 =>
            array(
                'id' => 19,
                'promocao_id' => 4,
                'arquivo' => 'prato.jpg',
                'ordem' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
            19 =>
            array(
                'id' => 20,
                'promocao_id' => 4,
                'arquivo' => 'prato2.jpg',
                'ordem' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'status' => '1',
            ),
        ));
    }
}
