<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodosTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {
        DB::table('periodos')->delete();

        DB::table('periodos')->insert(array(
            0 =>
            array(
                'id' => 1,
                'promocaounidade_id' => 1,
                'nome' => '12h às 13h30',
                'periodo' => 'tarde',
                'created_at' => '2018-04-10 14:51:18',
                'updated_at' => NULL,
                'status' => '0',
            ),
            1 =>
            array(
                'id' => 2,
                'promocaounidade_id' => 1,
                'nome' => '19h às 21h',
                'periodo' => 'noite',
                'created_at' => '2018-04-10 14:51:18',
                'updated_at' => NULL,
                'status' => '0',
            ),
            2 =>
            array(
                'id' => 3,
                'promocaounidade_id' => 1,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-07 09:36:17',
                'updated_at' => NULL,
                'status' => '1',
            ),
            3 =>
            array(
                'id' => 4,
                'promocaounidade_id' => 1,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-07 09:36:17',
                'updated_at' => NULL,
                'status' => '1',
            ),
            4 =>
            array(
                'id' => 5,
                'promocaounidade_id' => 1,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-07 09:36:17',
                'updated_at' => NULL,
                'status' => '1',
            ),
            5 =>
            array(
                'id' => 6,
                'promocaounidade_id' => 1,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-07 09:36:17',
                'updated_at' => NULL,
                'status' => '1',
            ),
            6 =>
            array(
                'id' => 7,
                'promocaounidade_id' => 1,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-07 09:36:17',
                'updated_at' => NULL,
                'status' => '1',
            ),
            7 =>
            array(
                'id' => 8,
                'promocaounidade_id' => 1,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-07 09:40:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            8 =>
            array(
                'id' => 9,
                'promocaounidade_id' => 1,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-07 09:40:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            9 =>
            array(
                'id' => 10,
                'promocaounidade_id' => 1,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-07 09:40:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            10 =>
            array(
                'id' => 11,
                'promocaounidade_id' => 2,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            11 =>
            array(
                'id' => 12,
                'promocaounidade_id' => 2,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            12 =>
            array(
                'id' => 13,
                'promocaounidade_id' => 2,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            13 =>
            array(
                'id' => 14,
                'promocaounidade_id' => 2,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            14 =>
            array(
                'id' => 15,
                'promocaounidade_id' => 2,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            15 =>
            array(
                'id' => 16,
                'promocaounidade_id' => 2,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            16 =>
            array(
                'id' => 17,
                'promocaounidade_id' => 2,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            17 =>
            array(
                'id' => 18,
                'promocaounidade_id' => 2,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-28 15:48:55',
                'updated_at' => NULL,
                'status' => '1',
            ),
            18 =>
            array(
                'id' => 19,
                'promocaounidade_id' => 3,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            19 =>
            array(
                'id' => 20,
                'promocaounidade_id' => 3,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            20 =>
            array(
                'id' => 21,
                'promocaounidade_id' => 3,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            21 =>
            array(
                'id' => 22,
                'promocaounidade_id' => 3,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            22 =>
            array(
                'id' => 23,
                'promocaounidade_id' => 3,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            23 =>
            array(
                'id' => 24,
                'promocaounidade_id' => 3,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            24 =>
            array(
                'id' => 25,
                'promocaounidade_id' => 3,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            25 =>
            array(
                'id' => 26,
                'promocaounidade_id' => 3,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            26 =>
            array(
                'id' => 27,
                'promocaounidade_id' => 4,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:07',
                'updated_at' => NULL,
                'status' => '1',
            ),
            27 =>
            array(
                'id' => 28,
                'promocaounidade_id' => 4,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            28 =>
            array(
                'id' => 29,
                'promocaounidade_id' => 4,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            29 =>
            array(
                'id' => 30,
                'promocaounidade_id' => 4,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            30 =>
            array(
                'id' => 31,
                'promocaounidade_id' => 4,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            31 =>
            array(
                'id' => 32,
                'promocaounidade_id' => 4,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            32 =>
            array(
                'id' => 33,
                'promocaounidade_id' => 4,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            33 =>
            array(
                'id' => 34,
                'promocaounidade_id' => 4,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            34 =>
            array(
                'id' => 35,
                'promocaounidade_id' => 5,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            35 =>
            array(
                'id' => 36,
                'promocaounidade_id' => 5,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            36 =>
            array(
                'id' => 37,
                'promocaounidade_id' => 5,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            37 =>
            array(
                'id' => 38,
                'promocaounidade_id' => 5,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            38 =>
            array(
                'id' => 39,
                'promocaounidade_id' => 5,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            39 =>
            array(
                'id' => 40,
                'promocaounidade_id' => 5,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            40 =>
            array(
                'id' => 41,
                'promocaounidade_id' => 5,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            41 =>
            array(
                'id' => 42,
                'promocaounidade_id' => 5,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            42 =>
            array(
                'id' => 43,
                'promocaounidade_id' => 6,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            43 =>
            array(
                'id' => 44,
                'promocaounidade_id' => 6,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            44 =>
            array(
                'id' => 45,
                'promocaounidade_id' => 6,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            45 =>
            array(
                'id' => 46,
                'promocaounidade_id' => 6,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            46 =>
            array(
                'id' => 47,
                'promocaounidade_id' => 6,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            47 =>
            array(
                'id' => 48,
                'promocaounidade_id' => 6,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            48 =>
            array(
                'id' => 49,
                'promocaounidade_id' => 6,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            49 =>
            array(
                'id' => 50,
                'promocaounidade_id' => 6,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            50 =>
            array(
                'id' => 51,
                'promocaounidade_id' => 7,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            51 =>
            array(
                'id' => 52,
                'promocaounidade_id' => 7,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            52 =>
            array(
                'id' => 53,
                'promocaounidade_id' => 7,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            53 =>
            array(
                'id' => 54,
                'promocaounidade_id' => 7,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            54 =>
            array(
                'id' => 55,
                'promocaounidade_id' => 7,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            55 =>
            array(
                'id' => 56,
                'promocaounidade_id' => 7,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:08',
                'updated_at' => NULL,
                'status' => '1',
            ),
            56 =>
            array(
                'id' => 57,
                'promocaounidade_id' => 7,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            57 =>
            array(
                'id' => 58,
                'promocaounidade_id' => 7,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            58 =>
            array(
                'id' => 59,
                'promocaounidade_id' => 8,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            59 =>
            array(
                'id' => 60,
                'promocaounidade_id' => 8,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            60 =>
            array(
                'id' => 61,
                'promocaounidade_id' => 8,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            61 =>
            array(
                'id' => 62,
                'promocaounidade_id' => 8,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            62 =>
            array(
                'id' => 63,
                'promocaounidade_id' => 8,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            63 =>
            array(
                'id' => 64,
                'promocaounidade_id' => 8,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            64 =>
            array(
                'id' => 65,
                'promocaounidade_id' => 8,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            65 =>
            array(
                'id' => 66,
                'promocaounidade_id' => 8,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            66 =>
            array(
                'id' => 67,
                'promocaounidade_id' => 9,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            67 =>
            array(
                'id' => 68,
                'promocaounidade_id' => 9,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            68 =>
            array(
                'id' => 69,
                'promocaounidade_id' => 9,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            69 =>
            array(
                'id' => 70,
                'promocaounidade_id' => 9,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            70 =>
            array(
                'id' => 71,
                'promocaounidade_id' => 9,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            71 =>
            array(
                'id' => 72,
                'promocaounidade_id' => 9,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            72 =>
            array(
                'id' => 73,
                'promocaounidade_id' => 9,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            73 =>
            array(
                'id' => 74,
                'promocaounidade_id' => 9,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            74 =>
            array(
                'id' => 75,
                'promocaounidade_id' => 10,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            75 =>
            array(
                'id' => 76,
                'promocaounidade_id' => 10,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            76 =>
            array(
                'id' => 77,
                'promocaounidade_id' => 10,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            77 =>
            array(
                'id' => 78,
                'promocaounidade_id' => 10,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            78 =>
            array(
                'id' => 79,
                'promocaounidade_id' => 10,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            79 =>
            array(
                'id' => 80,
                'promocaounidade_id' => 10,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            80 =>
            array(
                'id' => 81,
                'promocaounidade_id' => 10,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            81 =>
            array(
                'id' => 82,
                'promocaounidade_id' => 10,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            82 =>
            array(
                'id' => 83,
                'promocaounidade_id' => 11,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            83 =>
            array(
                'id' => 84,
                'promocaounidade_id' => 11,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:09',
                'updated_at' => NULL,
                'status' => '1',
            ),
            84 =>
            array(
                'id' => 85,
                'promocaounidade_id' => 11,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            85 =>
            array(
                'id' => 86,
                'promocaounidade_id' => 11,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            86 =>
            array(
                'id' => 87,
                'promocaounidade_id' => 11,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            87 =>
            array(
                'id' => 88,
                'promocaounidade_id' => 11,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            88 =>
            array(
                'id' => 89,
                'promocaounidade_id' => 11,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            89 =>
            array(
                'id' => 90,
                'promocaounidade_id' => 11,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            90 =>
            array(
                'id' => 91,
                'promocaounidade_id' => 12,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            91 =>
            array(
                'id' => 92,
                'promocaounidade_id' => 12,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            92 =>
            array(
                'id' => 93,
                'promocaounidade_id' => 12,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            93 =>
            array(
                'id' => 94,
                'promocaounidade_id' => 12,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            94 =>
            array(
                'id' => 95,
                'promocaounidade_id' => 12,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            95 =>
            array(
                'id' => 96,
                'promocaounidade_id' => 12,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            96 =>
            array(
                'id' => 97,
                'promocaounidade_id' => 12,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            97 =>
            array(
                'id' => 98,
                'promocaounidade_id' => 12,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            98 =>
            array(
                'id' => 99,
                'promocaounidade_id' => 13,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            99 =>
            array(
                'id' => 100,
                'promocaounidade_id' => 13,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            100 =>
            array(
                'id' => 101,
                'promocaounidade_id' => 13,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            101 =>
            array(
                'id' => 102,
                'promocaounidade_id' => 13,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            102 =>
            array(
                'id' => 103,
                'promocaounidade_id' => 13,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            103 =>
            array(
                'id' => 104,
                'promocaounidade_id' => 13,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            104 =>
            array(
                'id' => 105,
                'promocaounidade_id' => 13,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            105 =>
            array(
                'id' => 106,
                'promocaounidade_id' => 13,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            106 =>
            array(
                'id' => 107,
                'promocaounidade_id' => 14,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            107 =>
            array(
                'id' => 108,
                'promocaounidade_id' => 14,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            108 =>
            array(
                'id' => 109,
                'promocaounidade_id' => 14,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            109 =>
            array(
                'id' => 110,
                'promocaounidade_id' => 14,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            110 =>
            array(
                'id' => 111,
                'promocaounidade_id' => 14,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            111 =>
            array(
                'id' => 112,
                'promocaounidade_id' => 14,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            112 =>
            array(
                'id' => 113,
                'promocaounidade_id' => 14,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            113 =>
            array(
                'id' => 114,
                'promocaounidade_id' => 14,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            114 =>
            array(
                'id' => 115,
                'promocaounidade_id' => 15,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            115 =>
            array(
                'id' => 116,
                'promocaounidade_id' => 15,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            116 =>
            array(
                'id' => 117,
                'promocaounidade_id' => 15,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:10',
                'updated_at' => NULL,
                'status' => '1',
            ),
            117 =>
            array(
                'id' => 118,
                'promocaounidade_id' => 15,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            118 =>
            array(
                'id' => 119,
                'promocaounidade_id' => 15,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            119 =>
            array(
                'id' => 120,
                'promocaounidade_id' => 15,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            120 =>
            array(
                'id' => 121,
                'promocaounidade_id' => 15,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            121 =>
            array(
                'id' => 122,
                'promocaounidade_id' => 15,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            122 =>
            array(
                'id' => 123,
                'promocaounidade_id' => 16,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            123 =>
            array(
                'id' => 124,
                'promocaounidade_id' => 16,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            124 =>
            array(
                'id' => 125,
                'promocaounidade_id' => 16,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            125 =>
            array(
                'id' => 126,
                'promocaounidade_id' => 16,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            126 =>
            array(
                'id' => 127,
                'promocaounidade_id' => 16,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            127 =>
            array(
                'id' => 128,
                'promocaounidade_id' => 16,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            128 =>
            array(
                'id' => 129,
                'promocaounidade_id' => 16,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            129 =>
            array(
                'id' => 130,
                'promocaounidade_id' => 16,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            130 =>
            array(
                'id' => 131,
                'promocaounidade_id' => 17,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            131 =>
            array(
                'id' => 132,
                'promocaounidade_id' => 17,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            132 =>
            array(
                'id' => 133,
                'promocaounidade_id' => 17,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            133 =>
            array(
                'id' => 134,
                'promocaounidade_id' => 17,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            134 =>
            array(
                'id' => 135,
                'promocaounidade_id' => 17,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            135 =>
            array(
                'id' => 136,
                'promocaounidade_id' => 17,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            136 =>
            array(
                'id' => 137,
                'promocaounidade_id' => 17,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            137 =>
            array(
                'id' => 138,
                'promocaounidade_id' => 17,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            138 =>
            array(
                'id' => 139,
                'promocaounidade_id' => 18,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            139 =>
            array(
                'id' => 140,
                'promocaounidade_id' => 18,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            140 =>
            array(
                'id' => 141,
                'promocaounidade_id' => 18,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            141 =>
            array(
                'id' => 142,
                'promocaounidade_id' => 18,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:11',
                'updated_at' => NULL,
                'status' => '1',
            ),
            142 =>
            array(
                'id' => 143,
                'promocaounidade_id' => 18,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            143 =>
            array(
                'id' => 144,
                'promocaounidade_id' => 18,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            144 =>
            array(
                'id' => 145,
                'promocaounidade_id' => 18,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            145 =>
            array(
                'id' => 146,
                'promocaounidade_id' => 18,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            146 =>
            array(
                'id' => 147,
                'promocaounidade_id' => 19,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            147 =>
            array(
                'id' => 148,
                'promocaounidade_id' => 19,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            148 =>
            array(
                'id' => 149,
                'promocaounidade_id' => 19,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            149 =>
            array(
                'id' => 150,
                'promocaounidade_id' => 19,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            150 =>
            array(
                'id' => 151,
                'promocaounidade_id' => 19,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            151 =>
            array(
                'id' => 152,
                'promocaounidade_id' => 19,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            152 =>
            array(
                'id' => 153,
                'promocaounidade_id' => 19,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            153 =>
            array(
                'id' => 154,
                'promocaounidade_id' => 19,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            154 =>
            array(
                'id' => 155,
                'promocaounidade_id' => 20,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            155 =>
            array(
                'id' => 156,
                'promocaounidade_id' => 20,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            156 =>
            array(
                'id' => 157,
                'promocaounidade_id' => 20,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            157 =>
            array(
                'id' => 158,
                'promocaounidade_id' => 20,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            158 =>
            array(
                'id' => 159,
                'promocaounidade_id' => 20,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            159 =>
            array(
                'id' => 160,
                'promocaounidade_id' => 20,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            160 =>
            array(
                'id' => 161,
                'promocaounidade_id' => 20,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            161 =>
            array(
                'id' => 162,
                'promocaounidade_id' => 20,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-05-30 15:58:12',
                'updated_at' => NULL,
                'status' => '1',
            ),
            162 =>
            array(
                'id' => 163,
                'promocaounidade_id' => 21,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:51',
                'updated_at' => NULL,
                'status' => '1',
            ),
            163 =>
            array(
                'id' => 164,
                'promocaounidade_id' => 21,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:51',
                'updated_at' => NULL,
                'status' => '1',
            ),
            164 =>
            array(
                'id' => 165,
                'promocaounidade_id' => 21,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:51',
                'updated_at' => NULL,
                'status' => '1',
            ),
            165 =>
            array(
                'id' => 166,
                'promocaounidade_id' => 21,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:51',
                'updated_at' => NULL,
                'status' => '1',
            ),
            166 =>
            array(
                'id' => 167,
                'promocaounidade_id' => 21,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:51',
                'updated_at' => NULL,
                'status' => '1',
            ),
            167 =>
            array(
                'id' => 168,
                'promocaounidade_id' => 21,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            168 =>
            array(
                'id' => 169,
                'promocaounidade_id' => 21,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            169 =>
            array(
                'id' => 170,
                'promocaounidade_id' => 21,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            170 =>
            array(
                'id' => 171,
                'promocaounidade_id' => 22,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            171 =>
            array(
                'id' => 172,
                'promocaounidade_id' => 22,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            172 =>
            array(
                'id' => 173,
                'promocaounidade_id' => 22,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            173 =>
            array(
                'id' => 174,
                'promocaounidade_id' => 22,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            174 =>
            array(
                'id' => 175,
                'promocaounidade_id' => 22,
                'nome' => '19:00',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            175 =>
            array(
                'id' => 176,
                'promocaounidade_id' => 22,
                'nome' => '19:30',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            176 =>
            array(
                'id' => 177,
                'promocaounidade_id' => 22,
                'nome' => '20:00',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:19:52',
                'updated_at' => NULL,
                'status' => '1',
            ),
            177 =>
            array(
                'id' => 178,
                'promocaounidade_id' => 22,
                'nome' => '20:30',
                'periodo' => 'noite',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            178 =>
            array(
                'id' => 179,
                'promocaounidade_id' => 23,
                'nome' => '12:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            179 =>
            array(
                'id' => 180,
                'promocaounidade_id' => 23,
                'nome' => '12:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            180 =>
            array(
                'id' => 181,
                'promocaounidade_id' => 23,
                'nome' => '13:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            181 =>
            array(
                'id' => 182,
                'promocaounidade_id' => 23,
                'nome' => '13:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            182 =>
            array(
                'id' => 183,
                'promocaounidade_id' => 23,
                'nome' => '14:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            183 =>
            array(
                'id' => 184,
                'promocaounidade_id' => 23,
                'nome' => '14:30',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
            184 =>
            array(
                'id' => 185,
                'promocaounidade_id' => 23,
                'nome' => '15:00',
                'periodo' => 'tarde',
                'created_at' => '2018-06-05 10:26:15',
                'updated_at' => NULL,
                'status' => '1',
            ),
        ));
    }
}
