<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\Lead;
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

		return response()->json(['data' => $promocoes->get()]);
	}

	public function retrieve(Request $request, $clientePath, $promocaoPath) {
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

		/* dias que passaram do limite de agendamento por unidade */
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

		return response()->json(['data' => $promocao]);
	}

	public function cidade(Request $request) {
		// $hoje = date("Y-m-d H:i:s");

		$promocaoUnidades = PromocaoUnidade::join("unidades", "promocoes_unidades.unidade_id", "=", "unidades.id")
			->join("cidades", "unidades.cidade_id", "=", "cidades.codcidade")
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

		return response()->json(['data' => $promocoes]);
	}

	// Validar se necessita
	public function quantidadeVouchersDisponiveis(Request $request) {
		$promocao = Promocao::where("id", $request->promocaoId)->first();

		if (!$promocao) {
			return response()->json(['error' => 'Promoção não encontrada'], 500);
		}

		$leads = Lead::where([
			"promocao_id" => $request->promocaoId,
			"unidade_id" => $request->unidadeId,
			"data_voucher" => $request->dataVoucher,
		])->count();

		$qtdVouchers = $promocao->limite - $leads;

		return response()->json(['limite' => $qtdVouchers]);
	}
}
