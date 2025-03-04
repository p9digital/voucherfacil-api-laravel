<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Encurtado;

class GeneralController extends Controller {
  public function encurtado($codigo) {
    $encurtado = Encurtado::where("codigo", $codigo)->first();
    if ($encurtado) {
      return response()->json(["data" => $encurtado->url]);
    } else {
      return response()->json(["error" => "Endereço inválido"]);
    }
  }
}
