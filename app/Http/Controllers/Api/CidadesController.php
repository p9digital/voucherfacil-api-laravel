<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Promocao;
use App\Models\Unidade;

class CidadesController extends Controller {
  public function list(Request $request) {
    $cidades = Cidade::with('estado');
    if ($request->uf) {
      $cidades = $cidades->where('uf', $request->uf);
    }
    if ($request->com_promocoes) {
      $unidades = $this->cidadesComPromocoes();
      $cidades = $cidades->whereIn('codcidade', $unidades->pluck('cidade_id')->toArray());
    }

    return response()->json(['data' => $cidades->get()]);
  }

  public function retrieve(Request $request) {
    $cidade = Cidade::where('path', $request->cidadePath)
      // ->where('uf', $request->uf)
      ->firstOrFail();
    return response()->json(['data' => $cidade]);
  }

  private function cidadesComPromocoes() {
    $promocoes = Promocao::with('promocaounidades')->whereHas('promocaounidades.unidade', function ($query) {
      $query->where('status', '1');
    });
    $unidades = Unidade::whereHas('promocoesunidades', function ($query) use ($promocoes) {
      $query->whereIn('promocao_id', $promocoes->pluck('id')->toArray());
    });

    return $unidades;
  }
}
