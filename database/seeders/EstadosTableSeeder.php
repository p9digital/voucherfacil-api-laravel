<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('estados')->delete();

        DB::table('estados')->insert(array(
            0 =>
            array(
                'id' => 1,
                'coduf' => 12,
                'nome' => 'Acre',
                'uf' => 'AC',
                'regiao' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'coduf' => 27,
                'nome' => 'Alagoas',
                'uf' => 'AL',
                'regiao' => 2,
            ),
            2 =>
            array(
                'id' => 3,
                'coduf' => 16,
                'nome' => 'Amapá',
                'uf' => 'AP',
                'regiao' => 1,
            ),
            3 =>
            array(
                'id' => 4,
                'coduf' => 13,
                'nome' => 'Amazonas',
                'uf' => 'AM',
                'regiao' => 1,
            ),
            4 =>
            array(
                'id' => 5,
                'coduf' => 29,
                'nome' => 'Bahia',
                'uf' => 'BA',
                'regiao' => 2,
            ),
            5 =>
            array(
                'id' => 6,
                'coduf' => 23,
                'nome' => 'Ceará',
                'uf' => 'CE',
                'regiao' => 2,
            ),
            6 =>
            array(
                'id' => 7,
                'coduf' => 53,
                'nome' => 'Distrito Federal',
                'uf' => 'DF',
                'regiao' => 5,
            ),
            7 =>
            array(
                'id' => 8,
                'coduf' => 32,
                'nome' => 'Espírito Santo',
                'uf' => 'ES',
                'regiao' => 3,
            ),
            8 =>
            array(
                'id' => 9,
                'coduf' => 52,
                'nome' => 'Goiás',
                'uf' => 'GO',
                'regiao' => 5,
            ),
            9 =>
            array(
                'id' => 10,
                'coduf' => 21,
                'nome' => 'Maranhão',
                'uf' => 'MA',
                'regiao' => 2,
            ),
            10 =>
            array(
                'id' => 11,
                'coduf' => 51,
                'nome' => 'Mato Grosso',
                'uf' => 'MT',
                'regiao' => 5,
            ),
            11 =>
            array(
                'id' => 12,
                'coduf' => 50,
                'nome' => 'Mato Grosso do Sul',
                'uf' => 'MS',
                'regiao' => 5,
            ),
            12 =>
            array(
                'id' => 13,
                'coduf' => 31,
                'nome' => 'Minas Gerais',
                'uf' => 'MG',
                'regiao' => 3,
            ),
            13 =>
            array(
                'id' => 14,
                'coduf' => 15,
                'nome' => 'Pará',
                'uf' => 'PA',
                'regiao' => 2,
            ),
            14 =>
            array(
                'id' => 15,
                'coduf' => 25,
                'nome' => 'Paraíba',
                'uf' => 'PB',
                'regiao' => 2,
            ),
            15 =>
            array(
                'id' => 16,
                'coduf' => 41,
                'nome' => 'Paraná',
                'uf' => 'PR',
                'regiao' => 4,
            ),
            16 =>
            array(
                'id' => 17,
                'coduf' => 26,
                'nome' => 'Pernambuco',
                'uf' => 'PE',
                'regiao' => 2,
            ),
            17 =>
            array(
                'id' => 18,
                'coduf' => 22,
                'nome' => 'Piauí',
                'uf' => 'PI',
                'regiao' => 2,
            ),
            18 =>
            array(
                'id' => 19,
                'coduf' => 33,
                'nome' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'regiao' => 3,
            ),
            19 =>
            array(
                'id' => 20,
                'coduf' => 24,
                'nome' => 'Rio Grande do Norte',
                'uf' => 'RN',
                'regiao' => 2,
            ),
            20 =>
            array(
                'id' => 21,
                'coduf' => 43,
                'nome' => 'Rio Grande do Sul',
                'uf' => 'RS',
                'regiao' => 4,
            ),
            21 =>
            array(
                'id' => 22,
                'coduf' => 11,
                'nome' => 'Rondônia',
                'uf' => 'RO',
                'regiao' => 1,
            ),
            22 =>
            array(
                'id' => 23,
                'coduf' => 14,
                'nome' => 'Roraima',
                'uf' => 'RR',
                'regiao' => 1,
            ),
            23 =>
            array(
                'id' => 24,
                'coduf' => 42,
                'nome' => 'Santa Catarina',
                'uf' => 'SC',
                'regiao' => 4,
            ),
            24 =>
            array(
                'id' => 25,
                'coduf' => 35,
                'nome' => 'São Paulo',
                'uf' => 'SP',
                'regiao' => 3,
            ),
            25 =>
            array(
                'id' => 26,
                'coduf' => 28,
                'nome' => 'Sergipe',
                'uf' => 'SE',
                'regiao' => 2,
            ),
            26 =>
            array(
                'id' => 27,
                'coduf' => 17,
                'nome' => 'Tocantins',
                'uf' => 'TO',
                'regiao' => 1,
            ),
        ));
    }
}
