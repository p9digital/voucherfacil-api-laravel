<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Fechado;
use App\Models\Periodo;
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

  public function retrieve(Request $request) {
    $user = $request->user();

    $unidade = Unidade::with('diasFechados')->find($request->unidade);

    if (!$unidade) {
      return response()->json(['error' => 'Unidade não encontrada'], 404);
    }

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

    $unidade = new Unidade($request->all());
    if ($user->tipo === 'a') {
      $unidade->cliente_id = $user->cliente_id;
    }
    $salvo = $unidade->save();

    if (!$salvo) {
      Log::error('Unidade NÃO salva', ['nome' => $unidade->nome, 'email' => $unidade->email]);
      return response()->json(['error' => 'Erro ao salvar a unidade. Tente novamente mais tarde.'], 500);
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

    $unidade->fill($request->all());
    $senha = $request->input('password');
    if (empty($senha)) {
      unset($unidade->password);
    }
    $atualizado = $unidade->save();

    if (!$atualizado) {
      Log::error('Unidade NÃO atualizada', ['nome' => $unidade->nome, 'email' => $unidade->email]);
      return response()->json(['error' => 'Erro ao atualizar a unidade. Tente novamente mais tarde.'], 500);
    }

    return response()->json(['message' => "Unidade atualizada com sucesso!", 'data' => $unidade]);
  }

  public function remove(Request $request, Unidade $unidade) {
    $user = $request->user();
    if ($user->tipo === 's') {
      $deletado = $unidade->delete();

      if (!$deletado) {
        Log::error('Unidade NÃO deletada', ['nome' => $unidade->nome]);
        return response()->json(['error' => 'Erro ao remover a unidade. Tente novamente mais tarde.'], 500);
      }

      return response()->json(['message' => 'Unidade removida com sucesso!']);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }

  // Períodos
  public function storePeriodos(Request $request, Unidade $unidade) {
    $user = $request->user();

    if ($user->tipo !== 's')
      return response()->json(['error' => 'Unauthorized'], 401);

    foreach ($request->periodos as $periodo) {
      if (isset($periodo['id'])) {
        $atualizarPeriodo = Periodo::find($periodo['id']);
        $atualizarPeriodo->fill($periodo);
        $atualizarPeriodo->save();
      } else {
        $novoPeriodo = new Periodo($periodo);
        $novoPeriodo->save();
      }
    }

    return response()->json(['message' => "Unidade salva com sucesso!", 'data' => $unidade]);
  }

  public function removePeriodo(Request $request, Unidade $unidade, Periodo $periodo) {
    $user = $request->user();
    if ($user->tipo === 's') {
      if (!$periodo->delete()) {
        Log::error('Período NÃO deletado', ['nome' => $periodo->nome]);
        return response()->json(['error' => 'Erro ao remover o período. Tente novamente mais tarde.'], 500);
      }

      return response()->json(['message' => 'Período removido com sucesso!']);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }

  // Dias Fechados
  public function storeDiaFechado(Request $request, Unidade $unidade) {
    $user = $request->user();

    if ($user->tipo !== 's')
      return response()->json(['error' => 'Unauthorized'], 401);

    foreach ($request->diasFechados as $diaFechado) {
      if (isset($diaFechado['id'])) {
        $atualizarDiaFechado = Fechado::find($diaFechado['id']);
        $atualizarDiaFechado->update($diaFechado);
      } else {
        $novoDiaFechado = new Fechado($diaFechado);
        $novoDiaFechado->unidade_id = $unidade->id;
        $novoDiaFechado->save();
      }
    }

    return response()->json(['message' => "Dia fechado salvo com sucesso!", 'data' => $unidade]);
  }

  public function removeDiaFechado(Request $request, Unidade $unidade, Fechado $fechado) {
    $user = $request->user();
    if ($user->tipo === 's') {
      if (!$fechado->delete()) {
        Log::error('Dia fechado NÃO deletado', ['nome' => $fechado->nome]);
        return response()->json(['error' => 'Erro ao remover o dia fechado. Tente novamente mais tarde.'], 500);
      }

      return response()->json(['message' => 'Dia fechado removido com sucesso!']);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }
}
