<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promocao;

class SincronizaCidadesPromocoes extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'sync:cidade_promocao';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Une as cidades e promocoes num relacionamento proximo na tabela cidade_promocao';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    $promocoes = Promocao::all();
    $this->info($promocoes->count());

    foreach ($promocoes as $promocao) {
      if ($promocao->atualizaCidades()) {
        $this->info('Atualizado promo ' . $promocao->id);
      }
    }
  }
}
