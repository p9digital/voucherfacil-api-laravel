<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Estado;

class CommonController extends Controller {
  public function estados() {
    $estados = Estado::get();
    return response()->json([
      'success' => true,
      'data' => $estados
    ], 200);
  }

  public function cidades(Request $request) {
    $cidades = Cidade::where('uf', $request->estado_id)->get();
    return response()->json([
      'success' => true,
      'data' => $cidades
    ], 200);
  }

  public function cidadesPromocoes() {
    $hoje = date("Y-m-d H:i:s");

    $cidades = Cidade::with('promocoes')->with('estado')->get();

    $cidadesFiltradas = [];

    foreach ($cidades as $key => $cidade) {
      $cidadePromocoes =  isset($cidade->promocoes[0]) ? true : false;

      if ($cidadePromocoes) {
        array_push($cidadesFiltradas, $cidade);
      }
    }

    return response()->json(['data' => $cidadesFiltradas, 'success' => 200]);
  }
}
