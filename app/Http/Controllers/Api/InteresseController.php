<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Interesse as MailInteresse;
use App\Models\Interesse;
use App\Models\Promocao;

class InteresseController extends Controller {
  public function store(Request $request) {
    $interesse = new Interesse($request->all());
    $promocao = Promocao::find($interesse->promocao_id);

    if (!$interesse->save()) {
      return response()->json(['error' => 'Erro ao salvar interesse'], 500);
    }

    if (config('app.env') === "production") {
      Mail::to(["notificacaoleads@p9.digital"])
        ->send(new MailInteresse($interesse, $promocao));
    } else {
      Mail::to(["dev@p9.digital"])
        ->send(new MailInteresse($interesse, $promocao));
    }

    return response()->json(['data' => $interesse]);
  }
}
