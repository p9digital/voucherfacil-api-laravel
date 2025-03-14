<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('unidades')->delete();

        DB::table('unidades')->insert(array(
            0 =>
            array(
                'id' => 1,
                'cliente_id' => 1,
                'nome' => 'Alphaville',
                'path' => 'alphaville',
                'estado_id' => 35,
                'cidade_id' => 3505708,
                'bairro' => 'Alphaville Industrial',
                'endereco' => 'Alameda Madeira',
                'numero' => '328',
                'complemento' => 'Complexo Madeira - 2º piso',
                'telefone' => '(11) 3376-2136',
                'telefone2' => NULL,
                'lat' => '-23.4951937',
                'lng' => '-46.852308',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisalphaville',
                'instagram' => 'lentrecotedeparisalphaville',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            1 =>
            array(
                'id' => 2,
                'cliente_id' => 1,
                'nome' => 'Brasília',
                'path' => 'brasilia',
                'estado_id' => 53,
                'cidade_id' => 5300108,
                'bairro' => 'Comércio Local Sul',
                'endereco' => 'CLS 402',
                'numero' => '402',
                'complemento' => 'Bloco D, Loja 09',
                'telefone' => '(61) 3264-5780',
                'telefone2' => NULL,
                'lat' => '-15.8091323',
                'lng' => '-47.8850845',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisbrasilia',
                'instagram' => 'lentrecotedeparisbrasilia',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            2 =>
            array(
                'id' => 3,
                'cliente_id' => 1,
                'nome' => 'Campinas',
                'path' => 'campinas',
                'estado_id' => 35,
                'cidade_id' => 3509502,
                'bairro' => 'Parque Dom Pedro Shopping',
                'endereco' => 'Av. Guilherme Campos',
                'numero' => '500',
                'complemento' => 'Ala Alameda, loja RA02',
                'telefone' => '(19) 3209-2609',
                'telefone2' => NULL,
                'lat' => '-22.8480986',
                'lng' => '-47.0631409',
                'mapsId' => NULL,
                'facebook' => 'lentrecotecampinas',
                'instagram' => 'lentrecotedepariscampinas',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            3 =>
            array(
                'id' => 4,
                'cliente_id' => 1,
                'nome' => 'Curitiba',
                'path' => 'curitiba',
                'estado_id' => 41,
                'cidade_id' => 4106902,
                'bairro' => 'Centro',
                'endereco' => 'Alameda Doutor Carlos de Carvalho',
                'numero' => '1101',
                'complemento' => NULL,
                'telefone' => '(41) 3045-6055',
                'telefone2' => NULL,
                'lat' => '-25.4353286',
                'lng' => '-49.2852596',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedepariscuritiba',
                'instagram' => 'lentrecotedepariscuritiba',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            4 =>
            array(
                'id' => 5,
                'cliente_id' => 1,
                'nome' => 'Goiânia',
                'path' => 'goiania',
                'estado_id' => 52,
                'cidade_id' => 5208707,
                'bairro' => 'Jardim Goiás',
                'endereco' => 'Av Deputado Jamel Cecílio',
                'numero' => '3300',
                'complemento' => 'Shopping Flamboyant',
                'telefone' => '(62) 3091-2406',
                'telefone2' => NULL,
                'lat' => '-16.7094517',
                'lng' => '-49.2359044',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisgoiania',
                'instagram' => 'lentrecotedeparisgoiania',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            5 =>
            array(
                'id' => 6,
                'cliente_id' => 1,
                'nome' => 'Niterói',
                'path' => 'niteroi',
                'estado_id' => 33,
                'cidade_id' => 3303302,
                'bairro' => 'Plaza Shopping Niterói',
                'endereco' => 'Rua Quinze de Novembro',
                'numero' => '8',
                'complemento' => 'Espaço Gourmet, piso L4',
                'telefone' => '(21) 2710-1613',
                'telefone2' => NULL,
                'lat' => '-22.8964157',
                'lng' => '-43.1239728',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisniteroi',
                'instagram' => 'lentrecotedeparisniteroi',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            6 =>
            array(
                'id' => 7,
                'cliente_id' => 1,
                'nome' => 'Recife',
                'path' => 'recife',
                'estado_id' => 26,
                'cidade_id' => 2611606,
                'bairro' => 'Pina',
                'endereco' => 'Av República do Líbano',
                'numero' => '251',
                'complemento' => 'Shopping RioMar',
                'telefone' => '(81) 3040-8588',
                'telefone2' => NULL,
                'lat' => '-8.0862476',
                'lng' => '-34.8936737',
                'mapsId' => NULL,
                'facebook' => 'lentrecotederecife',
                'instagram' => 'lentrecotedeparisrecife',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            7 =>
            array(
                'id' => 8,
                'cliente_id' => 1,
                'nome' => 'Ribeirão Preto',
                'path' => 'ribeirao-preto',
                'estado_id' => 35,
                'cidade_id' => 3543402,
                'bairro' => 'Jardim Canadá',
                'endereco' => 'Av José Adolfo Bianco Molina',
                'numero' => '2135',
                'complemento' => NULL,
                'telefone' => '(16) 3421-9488',
                'telefone2' => NULL,
                'lat' => '-21.2120557',
                'lng' => '-47.8070121',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisribeiraopreto',
                'instagram' => 'lentrecotedeparisribeirao',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            8 =>
            array(
                'id' => 9,
                'cliente_id' => 1,
                'nome' => 'Barra',
                'path' => 'barra',
                'estado_id' => 33,
                'cidade_id' => 3304557,
                'bairro' => 'Barra',
                'endereco' => 'Av Ayrton Senna',
                'numero' => '2150',
                'complemento' => 'CasaShopping',
                'telefone' => '(21) 2108-6318',
                'telefone2' => NULL,
                'lat' => '-22.9927951',
                'lng' => '-43.3641048',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisbarra',
                'instagram' => 'lentrecotedeparisbarrarj',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            9 =>
            array(
                'id' => 10,
                'cliente_id' => 1,
                'nome' => 'Gávea',
                'path' => 'gavea',
                'estado_id' => 33,
                'cidade_id' => 3304557,
                'bairro' => 'Gávea',
                'endereco' => 'Rua Marquês de São Vicente',
                'numero' => '52',
                'complemento' => 'Shopping da Gávea',
                'telefone' => '(21) 3114-5380',
                'telefone2' => NULL,
                'lat' => '-22.9752405',
                'lng' => '-43.2284282',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisgavea',
                'instagram' => 'lentrecotedeparisgavearj',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            10 =>
            array(
                'id' => 11,
                'cliente_id' => 1,
                'nome' => 'Ipanema',
                'path' => 'ipanema',
                'estado_id' => 33,
                'cidade_id' => 3304557,
                'bairro' => 'Ipanema',
                'endereco' => 'Rua Prudente de Morais',
                'numero' => '1387',
                'complemento' => NULL,
                'telefone' => '(21) 3204-4043',
                'telefone2' => NULL,
                'lat' => '-22.9851892',
                'lng' => '-43.2101777',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisipanema',
                'instagram' => 'lentrecotedeparisipanema',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            11 =>
            array(
                'id' => 12,
                'cliente_id' => 1,
                'nome' => 'Tijuca',
                'path' => 'tijuca',
                'estado_id' => 33,
                'cidade_id' => 3304557,
                'bairro' => 'Tijuca',
                'endereco' => 'Av Maracanã',
                'numero' => '987',
                'complemento' => 'L3',
                'telefone' => '(21) 2565-7756',
                'telefone2' => NULL,
                'lat' => '-22.9219385',
                'lng' => '-43.2353733',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparistijuca',
                'instagram' => 'lentrecotedeparistijucarj',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            12 =>
            array(
                'id' => 13,
                'cliente_id' => 1,
                'nome' => 'São Caetano do Sul',
                'path' => 'sao-caetano-do-sul',
                'estado_id' => 35,
                'cidade_id' => 3548807,
                'bairro' => 'Park Shopping São Caetano',
                'endereco' => 'Al. Terracota',
                'numero' => '545',
                'complemento' => 'Espaço Cerâmica',
                'telefone' => '(11) 4233-8327',
                'telefone2' => NULL,
                'lat' => '-23.6257271',
                'lng' => '-46.5802789',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparissaocaetano',
                'instagram' => 'lentrecotedeparissaocaetano',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            13 =>
            array(
                'id' => 14,
                'cliente_id' => 1,
                'nome' => 'Higienópolis',
                'path' => 'higienopolis',
                'estado_id' => 35,
                'cidade_id' => 3550308,
                'bairro' => 'Higienópolis',
                'endereco' => 'Rua Pará',
                'numero' => '210',
                'complemento' => NULL,
                'telefone' => '(11) 3661-0935',
                'telefone2' => NULL,
                'lat' => '-23.5486918',
                'lng' => '-46.6597207',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparishigienopolis',
                'instagram' => 'lentrecotedeparishigienopolis',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            14 =>
            array(
                'id' => 15,
                'cliente_id' => 1,
                'nome' => 'Cidade Jardim',
                'path' => 'cidade-jardim',
                'estado_id' => 35,
                'cidade_id' => 3550308,
                'bairro' => 'Shopping Cidade Jardim',
                'endereco' => 'Av Magalhães de Castro',
                'numero' => '12000',
                'complemento' => 'Piso 3',
                'telefone' => '(11) 3198-9466',
                'telefone2' => NULL,
                'lat' => '-23.599244',
                'lng' => '-46.6978846',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedepariscidadejardim',
                'instagram' => 'lentrecotedepariscidadejardim',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            15 =>
            array(
                'id' => 16,
                'cliente_id' => 1,
                'nome' => 'Itaim Bibi',
                'path' => 'itaim-bibi',
                'estado_id' => 35,
                'cidade_id' => 3550308,
                'bairro' => 'Itaim Bibi',
                'endereco' => 'Rua Pedroso Alvarenga ',
                'numero' => '1135',
                'complemento' => NULL,
                'telefone' => '(11) 3078-6942',
                'telefone2' => NULL,
                'lat' => '-23.5827205',
                'lng' => '-46.6812862',
                'mapsId' => NULL,
                'facebook' => 'LEntrecoteDeParis',
                'instagram' => 'lentrecotedeparis',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            16 =>
            array(
                'id' => 17,
                'cliente_id' => 1,
                'nome' => 'Jardins',
                'path' => 'jardins',
                'estado_id' => 35,
                'cidade_id' => 3550308,
                'bairro' => 'Jardins',
                'endereco' => 'Rua Ministro Rocha Azevedo',
                'numero' => '1041',
                'complemento' => NULL,
                'telefone' => '(11) 3083-4420',
                'telefone2' => NULL,
                'lat' => '-23.5659379',
                'lng' => '-46.663886',
                'mapsId' => NULL,
                'facebook' => 'LEntrecoteDeParisJardins',
                'instagram' => 'lentrecotedeparisjardins',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            17 =>
            array(
                'id' => 18,
                'cliente_id' => 1,
                'nome' => 'Market Place',
                'path' => 'market-place',
                'estado_id' => 35,
                'cidade_id' => 3550308,
                'bairro' => 'Shopping Market Place',
                'endereco' => 'Av. Dr. Chucri Zaidan',
                'numero' => '902',
                'complemento' => 'Piso 1',
                'telefone' => '(11) 5181-7256',
                'telefone2' => NULL,
                'lat' => '-23.6211986',
                'lng' => '-46.70174',
                'mapsId' => NULL,
                'facebook' => 'lentrecotemktplace',
                'instagram' => 'lentrecotemktplace',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            18 =>
            array(
                'id' => 19,
                'cliente_id' => 1,
                'nome' => 'West Plaza',
                'path' => 'west-plaza',
                'estado_id' => 35,
                'cidade_id' => 3550308,
                'bairro' => 'Água Branca',
                'endereco' => 'Rua Engenheiro Stevenson',
                'numero' => '10',
                'complemento' => 'Shopping West Plaza - Piso térreo',
                'telefone' => '(11) 3868-2250',
                'telefone2' => NULL,
                'lat' => '-23.5264139',
                'lng' => '-46.6744368',
                'mapsId' => NULL,
                'facebook' => 'lentrecotewestplaza',
                'instagram' => 'lentrecotewestplaza',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
            19 =>
            array(
                'id' => 20,
                'cliente_id' => 1,
                'nome' => 'Uberlândia',
                'path' => 'uberlandia',
                'estado_id' => 31,
                'cidade_id' => 3170206,
                'bairro' => 'Center Shopping',
                'endereco' => 'Av. João Naves de Ávila',
                'numero' => '1331',
                'complemento' => 'Piso 2',
                'telefone' => '(34) 3236-6907',
                'telefone2' => NULL,
                'lat' => '-18.909833',
                'lng' => '-48.260596',
                'mapsId' => NULL,
                'facebook' => 'lentrecotedeparisuberlandia',
                'instagram' => 'lentrecotedeparisuberlandia',
                'created_at' => '2018-05-30 15:25:21',
                'updated_at' => NULL,
                'status' => '1',
            ),
        ));
    }
}
