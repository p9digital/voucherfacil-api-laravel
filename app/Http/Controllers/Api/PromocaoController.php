<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\Cliente;
use App\Models\Cidade;
use App\Models\Lead;
use App\Models\Foto;
use App\Models\PromocaoUnidade;
use App\Models\Unidade;

class PromocaoController extends Controller {
	public function list(Request $request) {
		// $hoje = date("Y-m-d H:i:s");

		$promocoes = Promocao::where([
			// ["dataInicio", "<=", $hoje],
			// ["dataFim", ">", $hoje],
			["pesquisa", "0"],
			["mostrar", "1"],
			["status", "1"]
		])
			->with('cliente', 'unidades', 'cidades', 'fotos');
		if ($request->clientePath) {
			$promocoes = $promocoes->whereHas("cliente", function ($query) use ($request) {
				$query->where("path", $request->clientePath);
			});
		}
		$promocoes = $promocoes->orderBy("dataFim", "desc")
			->orderBy("dataInicio", "desc");

		return response()->json(['data' => $promocoes->get()], 200);
	}

	public function cidade(Request $request) {
		$hoje = date("Y-m-d H:i:s");
		$promocaoUnidades = PromocaoUnidade::join("unidades", "promocoes_unidades.unidade_id", "=", "unidades.id")
			->join("cidades", "unidades.cidade_id", "=", "cidades.id")
			->where([
				['cidades.path', $request->cidadePath],
				['cidades.uf', $request->uf]
			])
			->get();
		$promocaoIds = $promocaoUnidades->pluck("promocao_id")->toArray();

		$promocoes = Promocao::with('cliente', 'unidades', 'cidades', 'fotos')
			->where([
				// ['dataInicio', '<=', $hoje],
				// ["dataFim", '>', $hoje],
				["mostrar", "1"],
				["pesquisa", "0"],
				["status", "1"]
			])
			->whereIn('id', $promocaoIds)
			->orderBy("dataFim", "desc")
			->orderBy("dataInicio", "desc")->get();

		return response()->json(['data' => $promocoes], 200);
	}

	// OLD ACTIONS
	public function promocoesPorCidades($uf, $path) {
		$cidade = Cidade::where([
			['path', '=', $path],
			['uf', '=', $uf]
		])->first();

		if (!isset($cidade) || !$cidade) {
			return response()->json(['success' => false, 'message' => 'cidade nao encontrada']);
		}

		$hoje = date("Y-m-d H:i:s");

		$promocoes = $cidade
			->promocoes()
			->with('fotos', 'cliente')
			->where([
				// ['dataInicio', '<=', $hoje],
				// ["dataFim", '>', $hoje],
				["mostrar", "1"],
				["promocoes.pesquisa", "0"],
				["promocoes.status", "1"]
			])
			->orderBy("dataFim", "desc")
			->orderBy("dataInicio", "desc")->get();

		return response()->json([
			'success' => true,
			'promocoes' => $promocoes,
			'cidade' => $cidade
		]);
	}

	public function promocoesPorClientes($path) {
		$cliente = Cliente::where('path', $path)->first();

		if (!isset($cliente) || !$cliente) {
			return response()->json(['success' => true, 'data' => []]);
		}

		$hoje = date("Y-m-d H:i:s");

		$promocoes = $cliente
			->promocoes()
			->with('fotos', 'cliente', 'cidades')
			->where([
				// ['dataInicio', '<=', $hoje],
				// ["dataFim", '>', $hoje],
				["mostrar", "1"],
				["promocoes.pesquisa", "0"],
				["promocoes.status", "1"]
			])
			->orderBy("dataFim", "desc")
			->orderBy("dataInicio", "desc")->get();

		return response()->json([
			'success' => true,
			'promocoes' => $promocoes,
			'cliente' => $cliente
		]);
	}

	public function promocoesPorClientesECidade($clientePath, $cidadePath) {
		$cliente = Cliente::where('path', $clientePath)->first();
		$cidade = Cidade::where('path', $cidadePath)->first();

		if (!isset($cliente) || !$cliente) {
			return response()->json(['success' => true, 'data' => []]);
		}

		$hoje = date("Y-m-d H:i:s");

		$promocoes = DB::table('promocoes')
			->join('promocoes_unidades', 'promocoes.id', '=', 'promocoes_unidades.promocao_id')
			->join('unidades', 'unidades.id', '=', 'promocoes_unidades.unidade_id')
			->join('cidades', 'cidades.codcidade', '=', 'unidades.cidade_id')
			->where([
				['cidades.id', '=', $cidade->id],
				['promocoes.pesquisa', '=', '0'],
				['promocoes.status', '=', '1']
			])
			->select('promocoes.*')
			->orderBy("dataFim", "desc")
			->orderBy("dataInicio", "desc")
			->get();

		$promocoesComItens = [];

		foreach ($promocoes as $key => $promocao) {
			$fotos = Foto::where('promocao_id', '=', $promocao->id)->get();

			$promocao->fotos = $fotos;
			$promocao->cliente = $cliente;

			array_push($promocoesComItens, $promocao);
		}


		return response()->json([
			'success' => true,
			'promocoes' => $promocoesComItens,
			'cliente' => $cliente
		]);
	}

	public function promocao($clientepath, $promocaopath) {
		date_default_timezone_set('America/Sao_Paulo');
		$hoje = date("Y-m-d");

		$cli = Cliente::where('path', $clientepath)->firstOrFail();
		$promocao = Promocao::with("promocaounidades.unidade.cidade", "promocaounidades.periodos", 'promocaounidades.unidade.diasFechados', "promocaounidades.desabilitados", "promocaounidades.unidade.cidade", "fotos")->where(['path' => $promocaopath, "cliente_id" => $cli->id, "pesquisa" => "0", "status" => "1"])->first();

		if ($promocao) {
			/*dias que passaram do limite de agendamento por unidade*/
			$promocaounidadeids = $promocao->promocaounidades->pluck("unidade_id")->toArray();

			$leads = Lead::selectRaw("unidade_id, data_voucher, COUNT(data_voucher) AS count")->whereIn("unidade_id", $promocaounidadeids)->where("promocao_id", $promocao->id)->whereNotNull("data_voucher")->groupBy("unidade_id", "data_voucher")->get();

			if ($promocao->promocaounidades) {
				// foreach ($promocao->promocaounidades as $promocaoUnidade) {
				// 	$limites = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("count", ">=", $promocao->limite)->pluck("data_voucher")->toArray();
				// 	$promocaoUnidade["diasDesabilitados"] = $limites;
				// 	$vouchersDia = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("data_voucher", $hoje)->count();
				// 	$promocaoUnidade["vouchersRestantes"] = $promocao->limite - $vouchersDia;
				// }
				//----------------------------Código abaixo específico oferta dipz artur alvim-------------------------
				$dataLimite = date("2021-03-04");
				foreach ($promocao->promocaounidades as $promocaoUnidade) {
					$promoLimite = $promocao->limite;
					$limites = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("count", ">=", $promoLimite)->pluck("data_voucher")->toArray();
					$promocaoUnidade["diasDesabilitados"] = ($limites ? $limites : array());
					$vouchersDia = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("data_voucher", $hoje)->count();
					$promocaoUnidade["vouchersRestantes"] = $promoLimite - $vouchersDia;

					if ($promocao->id == 37 && $dataLimite == $hoje) {
						$promoLimite = $promoLimite + 100;
						$limites = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("data_voucher", "2021-03-04")->where("count", ">=", $promoLimite)->pluck("data_voucher")->toArray();
						if (!$limites && in_array("2021-03-04", $promocaoUnidade["diasDesabilitados"])) {
							$index = array_search("2021-03-04", $promocaoUnidade["diasDesabilitados"]);
							if ($index >= 0) {
								$dias = [];
								for ($i = 0; $i < count($promocaoUnidade["diasDesabilitados"]); $i++) {
									if ($promocaoUnidade["diasDesabilitados"][$i] != "2021-03-04") {
										array_push($dias, $promocaoUnidade["diasDesabilitados"][$i]);
									}
								}
								$promocaoUnidade["diasDesabilitados"] = $dias;
							}
						}
						$vouchersDia = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("data_voucher", $hoje)->count();
						$promocaoUnidade["vouchersRestantes"] = $promoLimite - $vouchersDia;
					}
				}
			}

			$promocao['cliente'] = $cli;
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

	public function atualizaLimiteDeVouchers(Request $request) {
		date_default_timezone_set('America/Sao_Paulo');
		$promocao = Promocao::where("id", $request["promocaoId"])->first();

		$leads = Lead::where([
			["promocao_id", $request["promocaoId"]],
			["unidade_id", $request["unidadeId"]],
			["data_voucher", $request["dataVoucher"]],
		])->count();

		if (!$promocao) {
			return response()->json([
				'success' => false
			], 200);
		}

		// $qtdVouchers = $promocao->limite - $leads;
		//Código temporário específico promoção dipz artur alvim
		$dataLimite = date("2021-03-04");
		$qtdVouchers = ($promocao->id == 37 && $request["dataVoucher"] == $dataLimite ? 100 + $promocao->limite - $leads : $promocao->limite - $leads);
		//Fim Código temporário específico promoção dipz artur alvim

		return response()->json([
			'limite' => $qtdVouchers,
			'success' => true
		], 200);
	}
}
