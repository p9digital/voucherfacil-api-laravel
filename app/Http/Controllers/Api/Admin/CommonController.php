<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Estado;

class CommonController extends Controller {
  public function estados() {
    $estados = Estado::get();
    return response()->json(['data' => $estados]);
  }

  public function cidades(Request $request) {
    $cidades = Cidade::whereHas('estado', function ($query) use ($request) {
      $query->where('coduf', $request->estado_id);
    })->get();
    return response()->json(['data' => $cidades]);
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

    return response()->json(['data' => $cidadesFiltradas]);
  }
}
