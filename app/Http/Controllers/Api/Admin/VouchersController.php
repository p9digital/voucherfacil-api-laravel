<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Promocao;
use Illuminate\Support\Facades\Log;

class VouchersController extends Controller {
  public function list(Request $request) {
    $user = $request->user();
    if ($user->tipo !== 's' && $user->tipo !== 'a')
      return response()->json(['error' => 'Unauthorized'], 401);

    $busca = $request->busca ? $request->busca : '';

    $leads = Lead::with('cidade', 'promocao', 'unidade.cliente', 'periodo', 'pesquisa')
      ->whereNotNull("data_voucher")
      ->where(function ($query) use ($busca) {
        $query->where('nome', 'like', "%$busca%")->orWhere('voucher', 'like', "%$busca%");
      });
    if (($user->tipo == "a" || $user->tipo == "f") && !empty($user->cliente_id)) {
      $promocoes = Promocao::where("cliente_id", $user->cliente_id);
      $promocoesArray = $promocoes->select("id")->pluck("id")->toArray();
      $leads = $leads->whereIn("promocao_id", $promocoesArray);
      if ($user->tipo == "f") { // franqueado
        $leads = $leads->where("unidade_id", $user->unidade_id);
      }
    }
    if ($request->dia) {
      $leads = $leads->where("data_voucher", $user->dia);
    }

    return response()->json([
      'count' => $leads->count(),
      'data' => $leads->get()
    ]);
  }

  public function validar(Request $request) {
    $user = $request->user();
    $lead = Lead::where("voucher", $request->voucher)->first();
    if (
      $lead &&
      ($user->tipo === "s" ||
        ($user->tipo !== "s" && $lead->unidade->cliente_id === $user->cliente_id))
    ) {
      if ($lead->validado == "0") {
        $lead->validado = "1";
        // if (isset($request->ferramenta_validacao) && !empty($request->ferramenta_validacao) && is_string($request->ferramenta_validacao)) {
        //   $lead->ferramenta_validacao = $request->ferramenta_validacao;
        // }
        if ($lead->save()) {
          $leads = Lead::where("data_voucher", date("Y-m-d"));
          if ($user->tipo === "f") {
            $leads = $leads->where("unidade_id", $user->unidade);
          }
          //$leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"))->where("nome", "NOT LIKE", "%test%")->where("email", "NOT LIKE", "%test%");
          $validados = $leads->where("validado", "1")->count();
          $naoValidados = $leads->where("validado", "0")->count();

          return response()->json([
            'data' => array(
              "mensagem" => "Voucher validado com sucesso!",
              'total' => $leads->count(),
              'validados' => $validados,
              'naovalidados' => $naoValidados
            )
          ], 200);
        } else {
          return response()->json(['error' => 'Erro ao validar voucher'], 500);
        }
      } else {
        $leads = Lead::where("data_voucher", date("Y-m-d"));
        if ($user->tipo === "f") {
          $leads = $leads->where("unidade_id", $user->unidade);
        }
        //$leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"))->where("nome", "NOT LIKE", "%test%")->where("email", "NOT LIKE", "%test%");
        $validados = $leads->where("validado", "1")->count();
        $naoValidados = $leads->where("validado", "0")->count();

        return response()->json([
          'error' => 'Voucher já validado',
          'data' => array(
            'total' => $leads->count(),
            'validados' => $validados,
            'naovalidados' => $naoValidados
          )
        ], 500);
      }
    } else {
      return response()->json(['error' => 'Voucher inválido'], 500);
    }
  }
}
