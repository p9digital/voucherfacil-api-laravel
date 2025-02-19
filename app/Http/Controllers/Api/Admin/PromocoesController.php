<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promocao;

class PromocoesController extends Controller {
  public function list(Request $request) {
    $user = $request->user();

    $promocoes = Promocao::get();
    if ($user->tipo === 'a') {
      $promocoes = Promocao::where("cliente_id", $user->cliente_id)->get();
    } else if ($user->tipo === 'f') {
      $promocoes = Promocao::whereHas('promocaounidades', function ($query) use ($user) {
        $query->where("cliente_id", $user->cliente_id)->where("unidade_id", $user->unidade_id);
      })->get();
    }
    return response()->json(['data' => $promocoes], 200);
  }

  public function retrieve(Request $request, Promocao $promocao) {
    $user = $request->user();
    if (
      ($user->tipo === 'f')
      || ($user->tipo === 'a' && $user->cliente_id !== $promocao->cliente_id)
    )
      return response()->json(['error' => 'Unauthorized'], 401);

    return response()->json(['data' => $promocao]);
  }
}
