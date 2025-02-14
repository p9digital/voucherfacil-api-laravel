<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*MailTest*/
Route::controller(MailTestController::class)->group(function () {
    Route::prefix('mail')->group(function () {
        Route::get('agendamento/{id}', 'agendamento');
        Route::get('lead/{id}', 'lead');
        Route::get('voucher/{id}', 'voucher');
        Route::get('contato/{id}', 'contato');
        Route::get('aviso/{id}', 'aviso');
    });

    Route::get('sms/aviso/{sms?}/{email?}', 'smsAviso');
});
/*Fim MailTest*/

Route::controller(HomeController::class)->group(function () {
    //Busca fila SMS
    Route::get('filaSms', "filaSms");

    //Institucionais
    Route::get('politica-privacidade', "politica");
    Route::get('contato', "contato");
    Route::post('contato', "enviar");

    //QR Code
    Route::get('qrcode', 'qrcode')->name("qrcode");
    Route::get('qrcode/{codigo}', 'qrcode')->name("qrcode.busca");

    // Url Encurtada
    Route::get('/e/{codigo}', 'encurtado')->name("encurtado");
});
