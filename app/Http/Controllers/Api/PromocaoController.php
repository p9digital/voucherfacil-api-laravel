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
		if ($request->excluirId) {
			$promocoes = $promocoes->whereNot("id", $request->excluirId);
		}
		$promocoes = $promocoes->orderBy("dataFim", "desc")
			->orderBy("dataInicio", "desc");

		return response()->json(['data' => $promocoes->get()], 200);
	}

	public function retrieve(Request $request, $clientePath, $promocaoPath) {
		$hoje = date("Y-m-d");

		$promocao = Promocao::with(
			"cliente",
			"promocaounidades.desabilitados",
			"promocaounidades.unidade.cidade",
			'promocaounidades.unidade.diasFechados',
			"promocaounidades.periodos",
			"fotos"
		)
			->where(["path" => $promocaoPath, "pesquisa" => "0", "status" => "1"])
			->whereHas("cliente", function ($query) use ($clientePath) {
				$query->where("path", $clientePath);
			})
			->first();

		if (empty($promocao)) {
			return response()->json(['error' => 'Promoção não encontrada'], 500);
		}

		/*dias que passaram do limite de agendamento por unidade*/
		$promocaounidadeids = $promocao->promocaounidades->pluck("unidade_id")->toArray();

		$leads = Lead::selectRaw("unidade_id, data_voucher, COUNT(data_voucher) AS count")
			->whereIn("unidade_id", $promocaounidadeids)
			->where("promocao_id", $promocao->id)
			->whereNotNull("data_voucher")
			->groupBy("unidade_id", "data_voucher")
			->get();

		foreach ($promocao->promocaounidades as $promocaoUnidade) {
			$promoLimite = $promocao->limite; // Limite total geral da promoção por unidade
			$limites = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->where("count", ">=", $promoLimite)->pluck("data_voucher")->toArray();
			$promocaoUnidade["diasDesabilitados"] = ($limites ? $limites : array());
			$vouchersDia = $leads->where("unidade_id", $promocaoUnidade->unidade_id)->count(); // REVALIDAR ESTA LÓGICA: ->where("data_voucher", $hoje)
			$promocaoUnidade["vouchersRestantes"] = $promoLimite - $vouchersDia;
		}

		// calcula quantidade de vouchers já resgatados para limitar promoção
		// TODO: enviar flag (podeResgatar) ao invés da quantidade
		$promocao['vouchersResgatados'] = 0;
		if ($promocao->limite_vouchers && $promocao->limite_vouchers > 0) {
			$leadsCount = 0;
			foreach ($leads as $lead) {
				$leadsCount += $lead->count;
			}
			$promocao['vouchersResgatados'] = $leadsCount;
		}

		return response()->json(['data' => $promocao], 200);
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

	public function atualizaLimiteDeVouchers(Request $request) {
		$promocao = Promocao::where("id", $request->promocaoId)->first();

		$leads = Lead::where([
			["promocao_id", $request["promocaoId"]],
			["unidade_id", $request["unidadeId"]],
			["data_voucher", $request["dataVoucher"]],
		])->count();

		if (!$promocao) {
			return response()->json(['error' => ''], 500);
		}

		$qtdVouchers = $promocao->limite - $leads;

		return response()->json(['limite' => $qtdVouchers], 200);
	}
}
