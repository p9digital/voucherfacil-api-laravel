<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Interesse;
use App\Models\Promocao;

class InteresseController extends Controller {
  public function store(Request $request) {
    $interesse = new Interesse($request->all());
    $promocao = Promocao::where("id", "=", $interesse->promocao_id)->first();

    if (!$interesse->save()) {
      return response()->json(['data' => 'erro'], 500);
    }

    if (config('app.env') === "production") {
      Mail::to(["notificacaoleads@p9.digital"])
        ->queue(new \App\Mail\Interesse($interesse, $promocao));
    } else {
      Mail::to(["dev@p9.digital"])
        ->queue(new \App\Mail\Interesse($interesse, $promocao));
    }

    return response()->json(['data' => $interesse], 200);
  }
}
