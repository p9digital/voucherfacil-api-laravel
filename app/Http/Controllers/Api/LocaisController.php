<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Promocao;
use App\Models\Unidade;

class LocaisController extends Controller {
	public function cidadesComPromocoes() {
		$promocoes = Promocao::with('promocaounidades')->whereHas('promocaounidades.unidade', function ($query) {
			$query->where('status', '1');
		});
		$unidades = Unidade::whereHas('promocoesunidades', function ($query) use ($promocoes) {
			$query->whereIn('promocao_id', $promocoes->pluck('id')->toArray());
		});

		$cidades = Cidade::with('estado')->whereIn('id', $unidades->pluck('cidade_id')->toArray())->get();

		return response()->json(['data' => $cidades], 200);
	}

	public function buscaCidadesPorEstado($uf) {
		$cidades = Cidade::where('uf', $uf)->get();
		return response()->json([
			'success' => true,
			'data' => array('cidades' => $cidades)
		], 200);
	}

	public function cidadesPromocoes() {
		$hoje = date("Y-m-d H:i:s");

		$cidades = Cidade::with('promocoes')->with('estado')->get();

		$cidadesFiltradas = [];

		foreach ($cidades as $key => $cidade) {
			$cidadePromocoes =  isset($cidade->promocoes[0]) ? true : false;

			if ($cidadePromocoes) {
				array_push($cidadesFiltradas, $cidade);
			}
		}

		return response()->json(['data' => $cidadesFiltradas, 'success' => 200]);
	}
}
