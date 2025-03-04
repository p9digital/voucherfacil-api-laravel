<?php

namespace App\Console;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Lead;
use App\Models\Promocao;

class Kernel extends ConsoleKernel {
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule) {
    date_default_timezone_set('America/Sao_Paulo');

    $schedule->call(function () {
      Log::info('Cron job executado' . date("Y-m-d H:i:s"));

      $hoje = date("Y-m-d");
      if ($hoje != "2018-06-12") {
        $leads = Lead::where("data_voucher", $hoje)->get();
        foreach ($leads as $lead) {
          $promocao = Promocao::find($lead->promocao_id);
          \App\Jobs\SmsAviso::dispatch($lead, $promocao);

          Log::info('Enviando e-mail para ' . $lead->email);
          $date = date('d/m/Y', strtotime($lead->data_voucher));
          $lead->dia = $date;
          Mail::to([$lead->email])
            ->queue(new \App\Mail\Aviso($lead, $promocao, $lead->unidade, $date, $lead->periodo->nome));
        }
      }
    })->timezone('America/Sao_Paulo')->dailyAt('08:00');

    // Backup do banco de dados
    // $schedule->command('backup:clean')->daily()->at('01:00');
    // $schedule->command('backup:run')->twiceDaily(2, 14);
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands() {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
