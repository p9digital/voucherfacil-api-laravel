<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destaque;
use App\Models\Cidade;
use App\Models\Cliente;

class DestaqueController extends Controller {
    public function todos() {
        $destaques = Destaque::ativos()
            ->with('cliente', 'cidade', 'promocao')
            ->whereHas("promocao", function ($query) {
                $query->where("pesquisa", "0");
            })
            ->orderBy("created_at", "DESC")
            ->get();

        return response()->json([
            'success' => true,
            'destaques' => $destaques
        ]);
    }

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
