<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cidade;

class LocaisController extends Controller {
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
