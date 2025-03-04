<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Unidade;

class DashboardController extends Controller {
	public function hoje(Request $request) {
		$user = $request->user();

		if (!$user || !$request->promocao_id)
			return response()->json(['error' => 'Unauthorized'], 401);

		$hoje = date("Y-m-d");
		$leads = Lead::where(["promocao_id" => $request->promocao_id, "data_voucher" => $hoje]);
		if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
			$leads = $leads->where("unidade_id", $user->unidade_id);
		}

		return response()->json([
			'data' => array(
				'dia' => $hoje,
				'agendados' => $leads->count(),
				'validados' => $leads->where("validado", "1")->count(),
			)
		]);
	}

	public function ontem(Request $request) {
		$user = $request->user();

		if (!$user || !$request->promocao_id)
			return response()->json(['error' => 'Unauthorized'], 401);

		$ontem = date_create("-1 day")->format('Y-m-d');

		$leads = Lead::where(["promocao_id" => $request->promocao_id, "data_voucher" => $ontem]);
		if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
			$leads = $leads->where("unidade_id", $user->unidade_id);
		}

		return response()->json([
			'data' => array(
				'dia' => $ontem,
				'agendados' => $leads->count(),
				'validados' => $leads->where("validado", "1")->count(),
			)
		]);
	}

	public function ultimos30Dias(Request $request) {
		$user = $request->user();

		if (!$user || !$request->promocao_id)
			return response()->json(['error' => 'Unauthorized'], 401);

		$ultmioDia = date_create("-30 day")->format('Y-m-d');
		$hoje = date_create()->format('Y-m-d');

		$leads = Lead::where("promocao_id", $request->promocao_id)
			->where("data_voucher", ">", $ultmioDia)
			->where("data_voucher", "<", $hoje);
		if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
			$leads = $leads->where("unidade_id", $user->unidade_id);
		}

		return response()->json([
			'data' => array(
				'dia' => $ultmioDia,
				'agendados' => $leads->count(),
				'validados' => $leads->where("validado", "1")->count(),
			)
		]);
	}

	public function geral(Request $request) {
		$user = $request->user();

		if (!$user || !$request->promocao_id)
			return response()->json(['error' => 'Unauthorized'], 401);

		$leads = Lead::select("data_voucher", "validado")->where("promocao_id", $request->promocao_id);
		if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
			$leads = $leads->where("unidade_id", $user->unidade_id);
		}

		return response()->json(['data' => $leads->get()]);
	}

	public function charts(Request $request) {
		$user = $request->user();

		if (!$user || !$request->promocao_id)
			return response()->json(['error' => 'Unauthorized'], 401);

		$hoje = date_create()->format('Y-m-d');
		$unidades = Unidade::whereHas("promocoesunidades", function ($query) use ($request) {
			$query->where("promocao_id", $request->promocao_id);
		})->where("status", "1");
		$mes = date_create('-30 day')->format('Y-m-d');

		if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
			$unidades = $unidades->where("cliente_id", $user->cliente_id);
		} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
			$unidades = $unidades->where("cliente_id", $user->cliente_id)->where("id", $user->unidade_id);
		}

		$unidades = $unidades->get();

		$grafico = array(array('Unidade', 'Não Validados', 'Futuros', 'Validados'));

		foreach ($unidades as $unidade) {
			$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '0' AND l.unidade_id = '$unidade->id' AND l.promocao_id = $request->promocao_id) AND l.data_voucher > '$mes'")[0]->total;
			$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '0' AND l.data_voucher > '$hoje' AND l.promocao_id = $request->promocao_id) AND l.unidade_id = $unidade->id")[0]->total;
			$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '1' AND l.unidade_id = $unidade->id AND l.promocao_id = $request->promocao_id) AND l.data_voucher > '$mes'")[0]->total;

			$dados = array($unidade->nome, $totalNaoValidados, $totalFuturos, $totalValidados);
			array_push($grafico, $dados);
		}

		return response()->json(['data' => $grafico]);
	}
}
