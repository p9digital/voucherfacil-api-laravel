<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Promocao;

class VouchersController extends Controller {
  public function list(Request $request) {
    $user = $request->user();

    $busca = $request->busca ? $request->busca : '';

    $leads = Lead::with('cidade', 'promocao', 'unidade.cliente', 'periodo', 'pesquisa')
      ->whereNotNull("data_voucher")
      ->where(function ($query) use ($busca) {
        $query->where('nome', 'like', "%$busca%")
          ->orWhere('email', 'like', "%$busca%")
          ->orWhere('voucher', 'like', "%$busca%");
      });
    if (($user->tipo == "a" || $user->tipo == "f") && !empty($user->cliente_id)) {
      $promocoes = Promocao::whereHas('promocaounidades', function ($query) use ($user) {
        $query->where("cliente_id", $user->cliente_id);
        if ($user->tipo === "f") {
          $query->where("unidade_id", $user->unidade_id);
        }
      });
      $promocoesArray = $promocoes->select("id")->pluck("id")->toArray();
      $leads = $leads->whereIn("promocao_id", $promocoesArray);
      if ($user->tipo == "f") { // franqueado
        $leads = $leads->where("unidade_id", $user->unidade_id);
      }
    }
    if ($request->promocao_id) {
      $leads = $leads->where("promocao_id", $request->promocao_id);
    }
    if ($request->dia) {
      $leads = $leads->where("data_voucher", $request->dia);
    }

    return response()->json([
      'count' => $leads->count(),
      'data' => $leads->get(),
    ]);
  }

  public function validar(Request $request) {
    $user = $request->user();
    $lead = Lead::where("voucher", $request->voucher)->first();
    Log::info("Validando voucher: ", [$request->voucher, $user, $lead]);
    if (
      $lead &&
      ($user->tipo === "s" ||
        ($user->tipo !== "s" && $lead->unidade->cliente_id === $user->cliente_id))
    ) {
      if ($lead->validado === "0") {
        $lead->validado = "1";
        // if (isset($request->ferramenta_validacao) && !empty($request->ferramenta_validacao) && is_string($request->ferramenta_validacao)) {
        //   $lead->ferramenta_validacao = $request->ferramenta_validacao;
        // }
        if ($lead->save()) {
          return response()->json(["mensagem" => "Voucher validado com sucesso!"], 200);
        } else {
          return response()->json(['error' => 'Erro ao validar voucher'], 500);
        }
      } else {
        return response()->json(['error' => 'Voucher já validado'], 500);
      }
    } else {
      return response()->json(['error' => 'Voucher inválido'], 500);
    }
  }
}
