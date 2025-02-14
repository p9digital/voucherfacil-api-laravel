<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\Cliente;
use App\Models\Lead;

class PesquisaController extends Controller {
	// public function todas()
	// {
	// 	$hoje = date("Y-m-d H:i:s");

	// 	$promocoes = Promocao::where([
	// 		// ['dataInicio', '<=', $hoje],
	// 		// ["dataFim", '>', $hoje],
	// 		["pesquisa", "0"],
	// 		["mostrar", "1"],
	// 		["status", "1"]
	// 	])
	// 		->with('cliente', 'unidades', 'cidades', 'fotos')
	// 		->orderBy("dataFim", "desc")
	// 		->orderBy("dataInicio", "desc")->get();

	// 	return response()->json([
	// 		'success' => true,
	// 		'promocoes' => $promocoes
	// 	]);
	// }

	public function pesquisa($clientepath, $promocaopath) {
		date_default_timezone_set('America/Sao_Paulo');
		$hoje = date("Y-m-d");

		$cli = Cliente::where('path', $clientepath)->firstOrFail();
		$promocao = Promocao::with("cliente", "promocaounidades.unidade.cidade", "promocaounidades.periodos", 'promocaounidades.unidade.diasFechados', "promocaounidades.desabilitados", "promocaounidades.unidade.cidade", "fotos")->where(['path' => $promocaopath, "cliente_id" => $cli->id, "pesquisa" => "1", "status" => "1"])->first();

		if ($promocao) {
			/*dias que passaram do limite de agendamento por unidade*/
			$promocaounidadeids = $promocao->promocaounidades->pluck("unidade_id")->toArray();

			$leads = Lead::selectRaw("unidade_id, data_voucher, COUNT(data_voucher) AS count")->whereIn("unidade_id", $promocaounidadeids)->where("promocao_id", $promocao->id)->whereNotNull("data_voucher")->groupBy("unidade_id", "data_voucher")->get();

			if ($promocao->promocaounidades) {
				foreach ($promocao->promocaounidades as $promocaoUnidade) {
					$promoLimite = $promocao->limite;
					$limites = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("count", ">=", $promoLimite)->pluck("data_voucher")->toArray();
					$promocaoUnidade["diasDesabilitados"] = ($limites ? $limites : array());
					$vouchersDia = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("data_voucher", $hoje)->count();
					$promocaoUnidade["vouchersRestantes"] = $promoLimite - $vouchersDia;
				}
			}

			$promocao['vouchersResgatados'] = 0;
			if ($promocao->limite_vouchers && $promocao->limite_vouchers > 0) {
				$leadsCount = 0;
				foreach ($leads as $lead) {
					$leadsCount += $lead->count;
				}
				$promocao['vouchersResgatados'] = $leadsCount;
			}

			return response()->json([
				'promocao' => $promocao,
				'success' => true
			]);
		} else {
			return response()->json([
				'promocao' => [],
				'success' => true
			]);
		}
	}
}
