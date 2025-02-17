<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\Unidade;

class DashboardController extends Controller {
	public function hoje(Request $request) {
		$user = $request->user();
		if ($user) {
			$hoje = date_create()->format('Y-m-d');

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$totalHoje = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray AND l.validado = '1'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$totalHoje = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.validado = '1'")[0]->total;
				} else {
					$totalHoje = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.validado = '1'")[0]->total;
				}
			} else {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$totalHoje = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray AND l.validado = '1'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$totalHoje = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.validado = '1'")[0]->total;
				} else {
					$totalHoje = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$hoje' AND l.validado = '1'")[0]->total;
				}
			}

			return response()->json([
				'data' => array(
					'dia' => $hoje,
					'agendados' => $totalHoje,
					'validados' => $totalValidados,
				)
			], 200);
		}

		return response()->json(['error' => 'Token inválido'], 500);
	}

	public function ontem(Request $request) {
		$user = $request->user();
		if ($user) {
			$ontem = date_create("-1 day")->format('Y-m-d');

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray AND l.validado = '1'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.validado = '1'")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.validado = '1'")[0]->total;
				}
			} else {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray AND l.validado = '1'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.validado = '1'")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher = '$ontem' AND l.validado = '1'")[0]->total;
				}
			}

			return response()->json([
				'data' => array(
					'dia' => $ontem,
					'agendados' => $total,
					'validados' => $totalValidados,
				)
			], 200);
		}

		return response()->json(['error' => 'Token inválido'], 500);
	}

	public function ultimos30Dias(Request $request) {
		$user = $request->user();
		if ($user) {
			$ultmioDia = date_create("-30 day")->format('Y-m-d');
			$hoje = date_create()->format('Y-m-d');

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray AND l.validado = '1'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.validado = '1'")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.data_voucher < $hoje")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.validado = '1'")[0]->total;
				}
			} else {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray AND l.validado = '1'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.validado = '1'")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje')")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.data_voucher > '$ultmioDia' AND l.data_voucher < '$hoje') AND l.validado = '1'")[0]->total;
				}
			}

			return response()->json([
				'data' => array(
					'dia' => $ultmioDia,
					'agendados' => $total,
					'validados' => $totalValidados,
				)
			], 200);
		}
	}

	public function geral(Request $request) {
		$user = $request->user();
		if ($user) {
			$hoje = date_create()->format('Y-m-d');

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.promocao_id IN $promocoesArray")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje'")[0]->total;
				}
			} else {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.promocao_id IN $promocoesArray")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje'")[0]->total;
				}
			}

			return response()->json([
				'data' => array(
					'total' => $total,
					'validados' => $totalValidados,
					'naoValidados' => $totalNaoValidados,
					'futuros' => $totalFuturos,
				)
			], 200);
		}

		return response()->json(['error' => 'Token inválido'], 500);
	}

	public function mesAtual(Request $request) {
		$user = $request->user();
		if ($user) {
			$hoje = date_create()->format('Y-m-d');
			$inicio = date_create()->format('Y-m-01');
			$fim = date_create("+1 month")->format('Y-m-01');

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.data_voucher < '$fim' AND l.promocao_id IN $promocoesArray")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.data_voucher < '$fim' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.data_voucher < '$fim'")[0]->total;
				}
			} else {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.data_voucher < '$fim' AND l.promocao_id IN $promocoesArray")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.data_voucher < '$fim' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher > '$hoje' AND l.data_voucher < '$fim'")[0]->total;
				}
			}

			$mes = date_create()->format('m');

			return response()->json([
				'data' => array(
					'total' => $total,
					'validados' => $totalValidados,
					'naoValidados' => $totalNaoValidados,
					'futuros' => $totalFuturos,
					'mes' => $mes
				)
			], 200);
		}

		return response()->json(['error' => 'Token inválido'], 500);
	}

	public function mesAnterior(Request $request) {
		$user = $request->user();
		if ($user) {
			$inicio = date_create("-1 month")->format('Y-m-01');
			$fim = date_create()->format('Y-m-01');

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where([["cliente_id", $user->cliente_id], ["id", $request->promocao_id]]);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
				}
			} else {
				if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
				} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
					$promocoes = Promocao::where("cliente_id", $user->cliente_id);
					$promocoesArray = json_encode($promocoes->select("id")->pluck("id")->toArray());
					$promocoesArray = str_replace("[", "(", $promocoesArray);
					$promocoesArray = str_replace("]", ")", $promocoesArray);
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.promocao_id IN $promocoesArray AND l.unidade_id = $user->unidade_id AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
				} else {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '1' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.data_voucher >= '$inicio' AND l.data_voucher < '$fim'")[0]->total;
				}
			}

			$mes = date_create("-1 month")->format('m');

			return response()->json([
				'data' => array(
					'total' => $total,
					'validados' => $totalValidados,
					'naoValidados' => $totalNaoValidados,
					'mes' => $mes
				)
			], 200);
		}

		return response()->json(['error' => 'Token inválido'], 500);
	}

	public function grafico(Request $request) {
		$user = $request->user();

		if ($user) {
			$hoje = date_create()->format('Y-m-d');
			$unidades = Unidade::where("status", "1");
			$mes = date_create('-30 day')->format('Y-m-d');

			if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
				$unidades = $unidades->where("cliente_id", $user->cliente_id);
			} else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
				$unidades = $unidades->where("cliente_id", $user->cliente_id)->where("id", $user->unidade_id);
			}

			$unidades = $unidades->get();

			$grafico = array(
				array('Unidade', 'Não Validados', 'Futuros', 'Validados')
			);

			if ($request->promocao_id !== 0 && $request->promocao_id !== null) {
				foreach ($unidades as $unidade) {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.unidade_id = $unidade->id AND l.data_voucher > '$mes') AND l.promocao_id = $request->promocao_id")[0]->total;

					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '0' AND l.unidade_id = '$unidade->id' AND l.promocao_id = $request->promocao_id) AND l.data_voucher > '$mes'")[0]->total;

					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '0' AND l.data_voucher > '$hoje' AND l.promocao_id = $request->promocao_id) AND l.unidade_id = $unidade->id")[0]->total;

					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '1' AND l.unidade_id = $unidade->id AND l.promocao_id = $request->promocao_id) AND l.data_voucher > '$mes'")[0]->total;

					$dados = array($unidade->nome, $totalNaoValidados, $totalFuturos, $totalValidados);
					array_push($grafico, $dados);
				}
			} else {
				foreach ($unidades as $unidade) {
					$total = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.unidade_id = $unidade->id AND l.data_voucher > '$mes'")[0]->total;
					$totalNaoValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '0' AND l.unidade_id = '$unidade->id') AND l.data_voucher > '$mes'")[0]->total;
					$totalFuturos = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE l.validado = '0' AND l.data_voucher > '$hoje' AND l.unidade_id = $unidade->id")[0]->total;
					$totalValidados = DB::select("SELECT COUNT(*) AS total FROM leads l WHERE (l.validado = '1' AND l.unidade_id = $unidade->id) AND l.data_voucher > '$mes'")[0]->total;
					$dados = array($unidade->nome, $totalNaoValidados, $totalFuturos, $totalValidados);
					array_push($grafico, $dados);
				}
			}

			return response()->json(['data' => $grafico], 200);
		}

		return response()->json(['error' => 'Token inválido'], 500);
	}
}
