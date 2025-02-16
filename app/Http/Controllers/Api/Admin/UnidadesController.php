<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Unidade;

class UnidadesController extends Controller {
  public function list(Request $request) {
    $user = $request->user();
    if ($user->tipo !== 's' && $user->tipo !== 'a')
      return response()->json(['error' => 'Unauthorized'], 401);

    $busca = $request->busca ? $request->busca : '';
    $page = $request->page ? $request->page : 1;
    $page_size = $request->page_size ? $request->page_size : 100;
    $skip = ($page - 1) * $page_size;

    $unidades = Unidade::with('cliente')->where('nome', 'like', "%$busca%");
    if ($request->cliente_id) {
      $unidades = $unidades->where('cliente_id', $request->cliente_id);
    }
    $unidades = $unidades->orderByDesc('created_at');

    return response()->json([
      'count' => $unidades->count(),
      'data' => $request->all ? $unidades->get() : $unidades->skip($skip)->take($page_size)->get()
    ]);
  }

  public function retrieve(Request $request, Unidade $unidade) {
    $user = $request->user();
    if (
      ($user->tipo === 'f')
      || ($user->tipo === 'a' && $user->cliente_id !== $unidade->cliente_id)
    )
      return response()->json(['error' => 'Unauthorized'], 401);

    return response()->json(['data' => $unidade]);
  }

  public function store(Request $request) {
    $user = $request->user();
    Validator::make($request->all(), [
      'cliente_id' => 'required',
      'nome' => 'required',
      'path' => 'required',
      'estado_id' => 'required',
      'cidade_id' => 'required',
      'bairro' => 'required',
      'endereco' => 'required',
      'numero' => 'required',
    ], [
      'required' => 'O campo :attribute é obrigatório.'
    ])->validate();

    $estado = Estado::where('uf', $request->estado_id)->first();

    $unidade = new Unidade($request->all());
    $unidade->estado_id = $estado->id;
    if ($user->tipo === 'a') {
      $unidade->cliente_id = $user->cliente_id;
    }
    $salvo = $unidade->save();

    if (!$salvo) {
      Log::error('Unidade NÃO salva', ['nome' => $unidade->nome, 'email' => $unidade->email]);
    }

    return response()->json(['message' => "Unidade salva com sucesso!", 'data' => $unidade]);
  }

  public function update(Request $request, Unidade $unidade) {
    Validator::make($request->all(), [
      'cliente_id' => 'required',
      'nome' => 'required',
      'path' => 'required',
      'estado_id' => 'required',
      'cidade_id' => 'required',
      'bairro' => 'required',
      'endereco' => 'required',
      'numero' => 'required',
    ], [
      'required' => 'O campo :attribute é obrigatório.'
    ])->validate();

    $estado = Estado::where('uf', $request->estado_id)->first();

    $unidade->fill($request->all());
    $unidade->estado_id = $estado->id;
    $senha = $request->input('password');
    if (empty($senha)) {
      unset($unidade->password);
    }
    $atualizado = $unidade->save();

    if (!$atualizado) {
      Log::error('Unidade NÃO atualizada', ['nome' => $unidade->nome, 'email' => $unidade->email]);
    }

    return response()->json(['message' => "Unidade atualizada com sucesso!", 'data' => $unidade]);
  }

  public function destroy(Request $request, Unidade $unidade) {
    $user = $request->user();
    if ($user->tipo === 's') {
      $deletado = $unidade->delete();

      if (!$deletado) {
        Log::error('Unidade NÃO deletada', ['nome' => $unidade->nome]);
      }

      return response()->json(['message' => 'Unidade removida com sucesso!'], 200);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }
}
