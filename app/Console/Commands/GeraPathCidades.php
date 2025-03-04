<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Cidade;

class GeraPathCidades extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'gerapath:cidades';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Cria path com e sem uf para as cidades';

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
    $cidades = Cidade::all();
    foreach ($cidades as $cidade) {
      $cidade->path = Str::slug($cidade->nome);
      $cidade->path_com_uf = strtolower($cidade->estado->uf) . "_"  . $cidade->path;

      $this->info('Path com uf gerado: ' . $cidade->path_com_uf);

      $cidade->save();
    }
  }
}
