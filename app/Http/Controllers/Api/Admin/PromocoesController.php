<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\PromocaoUnidade;
use Illuminate\Support\Facades\Validator;

class PromocoesController extends Controller {
  public function list(Request $request) {
    $user = $request->user();

    $promocoes = Promocao::with('cliente', 'cidades');
    if ($user->tipo === 'a') {
      $promocoes = $promocoes->where("cliente_id", $user->cliente_id);
    } else if ($user->tipo === 'f') {
      $promocoes = $promocoes->whereHas('promocaounidades', function ($query) use ($user) {
        $query->where("cliente_id", $user->cliente_id)->where("unidade_id", $user->unidade_id);
      });
    }
    if ($request->cliente_id) {
      $promocoes = $promocoes->where("cliente_id", $request->cliente_id);
    }

    return response()->json(['data' => $promocoes->get()], 200);
  }

  public function retrieve(Request $request, Promocao $promocao) {
    $user = $request->user();
    if (
      ($user->tipo === 'f')
      || ($user->tipo === 'a' && $user->cliente_id !== $promocao->cliente_id)
    )
      return response()->json(['error' => 'Unauthorized'], 401);

    return response()->json(['data' => $promocao->with('promocaounidades.unidade', 'promocaounidades.periodos')->first()]);
  }

  public function update(Request $request, Promocao $promocao) {
    Validator::make($request->all(), [
      'cliente_id' => 'required',
      'titulo' => 'required',
      'path' => 'required',
      'valor' => 'required',
      'codigo' => 'required',
      'dataInicio' => 'required',
      'dataFim' => 'required',
      'dataPublicacao' => 'required',
    ], [
      'required' => 'O campo :attribute é obrigatório.'
    ])->validate();

    $promocao->fill($request->all());
    $atualizado = $promocao->save();

    if (!$atualizado) {
      Log::error('Unidade NÃO atualizada', ['titulo' => $promocao->titulo]);
    }

    return response()->json(['message' => "Promoção atualizada com sucesso!", 'data' => $promocao]);
  }

  public function storePromocaoUnidades(Request $request, Promocao $promocao) {
    $user = $request->user();
    Log::info($request->promocaounidades);
    if ($user->tipo === 'f' || $user->tipo === 'a' && $user->cliente_id !== $promocao->cliente_id)
      return response()->json(['error' => 'Unauthorized'], 401);
    $promocao->promocaounidades()->delete();
    foreach ($request->promocaounidades as $promocaounidade) {
      PromocaoUnidade::create(['promocao_id' => $promocao->id, 'unidade_id' => $promocaounidade['value']]);
    }

    return response()->json(['message' => "Unidades cadastradas salva com sucesso!", 'data' => $promocao]);
  }
}
