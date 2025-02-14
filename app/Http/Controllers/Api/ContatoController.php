<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contato;
use App\Models\Empresa;

class ContatoController extends Controller {

    public function storeContato(Request $request) {
        $validatedData = $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'mensagem' => 'required'
        ], [
            'required' => "O campo é obrigatório",
            'email' => "E-mail inválido"
        ]);

        $contato = new Contato($request->all());

        if ($contato->save()) {
            if (config('app.env') === "production") {
                Mail::to(['comercial@voucherfacil.com.br'])
                    ->bcc('notificacoesleads@publi9.com.br')
                    ->queue(new \App\Mail\Contato($contato));
            } else {
                Mail::to(['heitor.hatakeyama@publi9.com.br'])
                    ->queue(new \App\Mail\Contato($contato));
            }

            return response()->json([
                'success' => true,
                'data' => $contato,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'error',
            ], 200);
        }
    }

    public function storeEmpresa(Request $request) {
        $divulgue = new Empresa($request->all());

        if ($divulgue->save()) {
            if (config('app.env') === "production") {
                Mail::to(['comercial@voucherfacil.com.br'])
                    ->bcc('notificacoesleads@publi9.com.br')
                    ->queue(new \App\Mail\Divulgue($divulgue));
            } else {
                Mail::to(['heitor.hatakeyama@publi9.com.br'])
                    ->queue(new \App\Mail\Divulgue($divulgue));
            }

            return response()->json([
                'success' => true,
                'data' => $divulgue,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'error',
            ], 200);
        }
    }
}
