<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailTestController;

Route::get('/', function () {
  return view('welcome');
});

/*MailTest*/
Route::controller(MailTestController::class)->group(function () {
  Route::prefix('mail')->group(function () {
    Route::get('agendamento', 'agendamento');
    Route::get('agendamento/{id}', 'agendamento');
    Route::get('aviso', 'aviso');
    Route::get('aviso/{id}', 'aviso');
    Route::get('contato', 'contato');
    Route::get('contato/{id}', 'contato');
    Route::get('divulgue', 'divulgue');
    Route::get('divulgue/{id}', 'divulgue');
    Route::get('interesse', 'interesse');
    Route::get('interesse/{id}', 'interesse');
    Route::get('lead', 'lead');
    Route::get('lead/{id}', 'lead');
    Route::get('pesquisa', 'pesquisa');
    Route::get('pesquisa/{id}', 'pesquisa');
    Route::get('voucher', 'voucher');
    Route::get('voucher/{id}', 'voucher');
  });

  Route::get('disparar/aviso/{sms?}/{email?}', 'smsAviso');
});
/*Fim MailTest*/

Route::controller(HomeController::class)->group(function () {
  //Busca fila SMS
  Route::get('filaSms', "filaSms");

  //QR Code
  Route::get('qrcode', 'qrcode')->name("qrcode");
  Route::get('qrcode/{codigo}', 'qrcode')->name("qrcode.busca");
});
