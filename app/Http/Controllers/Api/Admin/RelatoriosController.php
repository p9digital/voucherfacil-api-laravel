<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Log;
use Illuminate\Http\Request;

class RelatoriosController extends Controller {

  public function leads(Request $request) {
    $user = $request->user();

    if (!$user)
      return response()->json(['error' => 'Unauthorized'], 401);

    $leads = Lead::with("promocao", "unidade");
    if ($request->cliente_id) {
      $leads = $leads->whereHas("promocao", function ($query) use ($request) {
        $query->where("cliente_id", $request->cliente_id);
      });
    }
    if ($request->promocao_id) {
      $leads = $leads->where("promocao_id", $request->promocao_id);
    }
    if ($request->busca) {
      $leads = $leads->where(function ($query) use ($request) {
        $query->where('voucher', 'LIKE', "%$request->busca%")
          ->orWhere('nome', 'LIKE', "%$request->busca%")
          ->orWhere('email', 'LIKE', "%$request->busca%")
          ->orWhere('telefone', 'LIKE', "%$request->busca%");
      });
    }
    if ($request->dataInicio) {
      $leads = $leads->where("data_voucher", ">=", $request->dataInicio);
    }
    if ($request->dataFim) {
      $leads = $leads->where("data_voucher", "<=", $request->dataFim);
    }

    return response()->json(["data" => $leads->get()]);
  }

  public function logs(Request $request) {
    $user = $request->user();

    if (!$user)
      return response()->json(['error' => 'Unauthorized'], 401);

    $logs = Log::with("usuario");
    if ($user->tipo === "s") {
      if ($request->cliente_id) {
        $logs = $logs->whereHas("usuario", function ($query) use ($request) {
          $query->where("cliente_id", $request->cliente_id);
        });
      }
    } else {
      $logs = $logs->whereHas("usuario", function ($query) use ($user) {
        $query->where("cliente_id", $user->cliente_id);
      });
    }
    if ($request->busca) {
      $logs = $logs->where(function ($query) use ($request) {
        $query->where('log', 'LIKE', "%$request->busca%")
          ->orWhereHas('usuario', function ($query2) use ($request) {
            $query2->where('name', 'LIKE', "%$request->busca%")
              ->orWhere('email', 'LIKE', "%$request->busca%");
          });
      });
    }
    if ($request->dataInicio) {
      $logs = $logs->where("created_at", ">=", "$request->dataInicio 00:00:00");
    }
    if ($request->dataFim) {
      $logs = $logs->where("created_at", "<=", "$request->dataFim 23:59:59");
    }

    return response()->json(["data" => $logs->get()]);
  }
}
