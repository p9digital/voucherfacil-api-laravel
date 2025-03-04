<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('backup:clean')->daily()->at('01:00')
  ->onFailure(function () {
    Log::error("Erro ao limpar backup do banco de dados");
  })
  ->onSuccess(function () {
    Log::info("Limpeza de backup realizado com sucesso");
  });
Schedule::command('backup:run')->twiceDaily(2, 14)
  ->onFailure(function () {
    Log::error("Erro ao realizar backup do banco de dados");
  })
  ->onSuccess(function () {
    Log::info("Backup realizado com sucesso");
  });
