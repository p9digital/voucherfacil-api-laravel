<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\Lead;

class PesquisaController extends Controller {
	public function retrieve(Request $request, $clientePath, $promocaoPath) {
		$promocao = Promocao::with(
			"cliente",
			"promocaounidades.desabilitados",
			"promocaounidades.unidade.cidade",
			'promocaounidades.unidade.diasFechados',
			"promocaounidades.periodos",
			"fotos"
		)
			->where(["path" => $promocaoPath, "pesquisa" => "1", "status" => "1"])
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
}
