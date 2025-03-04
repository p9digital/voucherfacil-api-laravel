<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Foto;

class CorrigePathsFotos extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'fotos:corrige_path';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }

  public function removeString($path) {
    return str_replace("foto_", "", $path);
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle() {
    $fotos = Foto::all();
    foreach ($fotos as $foto) {
      $foto->foto_desktop = $this->removeString($foto->foto_desktop);
      $foto->foto_mob = $this->removeString($foto->foto_mob);
      $foto->foto_card = $this->removeString($foto->foto_card);
      $foto->foto_desktop_xl = $this->removeString($foto->foto_desktop_xl);
      $foto->foto_mob_xs = $this->removeString($foto->foto_mob_xs);

      $foto->save();
    }
  }
}
