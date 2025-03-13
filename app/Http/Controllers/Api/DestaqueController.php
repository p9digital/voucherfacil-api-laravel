<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Promocao;

class DestaqueController extends Controller {
  public function list(Request $request) {
    $destaques = Promocao::with('cliente', 'fotos')
      ->where(["pesquisa" => "0", "mostrar" => "1", "status" => "1"])
      ->orderBy("dataFim", "DESC")
      ->orderBy("dataInicio", "DESC")
      ->get();

    return response()->json(["data" => $destaques]);
  }

  // Falta implementar CRUD de destaques?
  // public function list(Request $request) {
  //   $destaques = Destaque::with('cliente', 'cidade', 'promocao.fotos')
  //     ->whereHas("promocao", function ($query) {
  //       $query->where("pesquisa", "0");
  //     })
  //     ->orderBy("created_at", "DESC")
  //     ->where("status", "1")
  //     ->get();

  //   return response()->json(["data" => $destaques]);
  // }

  public function porCidade($uf, $pathCidade) {
    $cidade = Cidade::where([
      ['path', '=', $pathCidade],
      ['uf', '=', $uf]
    ])->first();

    if (!isset($cidade) || !$cidade) {
      return response()->json(['success' => false, 'message' => 'cidade nao encontrada']);
    }

    $destaques = $cidade
      ->destaques()
      ->ativos()
      ->with('cliente', 'promocao')
      ->whereHas("promocao", function ($query) {
        $query->where("pesquisa", "0");
      })
      ->get();

    return response()->json([
      'success' => true,
      'destaques' => $destaques,
      'cidade' => $cidade
    ]);
  }

  public function porCliente($pathCliente) {
    $cliente = Cliente::where('path', $pathCliente)->first();

    if (!isset($cliente) || !$cliente) {
      return response()->json(['success' => true, 'data' => []]);
    }

    $destaques = $cliente
      ->destaques()
      ->ativos()
      ->with('cidade', 'promocao')
      ->whereHas("promocao", function ($query) {
        $query->where("pesquisa", "0");
      })
      ->get();

    return response()->json([
      'success' => true,
      'destaques' => $destaques,
      'cliente' => $cliente
    ]);
  }
}
