<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class RelatoriosController extends Controller {

  public function leads(Request $request) {
    $user = $request->user();

    if (!$user)
      return response()->json(['error' => 'Unauthorized'], 401);

    $leads = Lead::with("promocao", "unidade");
    if ($request->cliente) {
      $leads = $leads->whereHas("promocao", function ($query) use ($request) {
        $query->where("cliente_id", $request->cliente);
      });
    }
    if ($request->promocao) {
      $leads = $leads->where("promocao_id", $request->promocao);
    }
    if ($request->dataInicio) {
      $leads = $leads->where("data_voucher", ">=", $request->dataInicio);
    }
    if ($request->dataFim) {
      $leads = $leads->where("data_voucher", "<=", $request->dataFim);
    }

    return response()->json(["data" => $leads->get()]);
  }
}
