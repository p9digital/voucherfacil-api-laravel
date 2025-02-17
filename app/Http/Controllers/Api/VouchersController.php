<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Models\Lead;
use App\Models\Promocao;
use App\Models\User;
use App\Models\Pesquisa;
use App\Mail\Agendamento;
use App\Mail\Pesquisa as AgendamentoPesquisa;

class VouchersController extends Controller {

  // Rotas de dados

  public function leads(Request $request) {
    date_default_timezone_set('America/Sao_Paulo');
    //apiLogin eh um helper
    $user = User::where('token', $request->token)->first();
    if (isset($request->token) && !empty($request->token) && $user) {
      $leads = Lead::whereNotNull("data_voucher");
      //$leads = Lead::whereNotNull("data_voucher")->where("nome", "NOT LIKE", "%test%")->where("email", "NOT LIKE", "%test%");
      if (!empty($user->cliente_id) && $user->tipo == "a") { //franqueadora
        $promocoes = Promocao::where("cliente_id", $user->cliente_id);
        $promocoesArray = $promocoes->select("id")->pluck("id")->toArray();
        $leads = $leads->whereIn("promocao_id", $promocoesArray);
      } else if (!empty($user->cliente_id) && $user->tipo == "f") { // franqueado
        $promocoes = Promocao::where("cliente_id", $user->cliente_id);
        $promocoesArray = $promocoes->select("id")->pluck("id")->toArray();
        $leads = $leads->whereIn("promocao_id", $promocoesArray)->where("unidade_id", $user->unidade_id);
      }

      return response()->json([
        'success' => true,
        'data' => array(
          'leads' => $leads->get()
        )
      ], 200);
    }

    return response()->json(['success' => false, 'error' => 'token inválido'], 500);
  }

  public function vouchers(Request $request) {
    date_default_timezone_set('America/Sao_Paulo');
    //apiLogin eh um helper
    $user = User::where('token', $request->token)->first();
    if (isset($request->token) && !empty($request->token) && $user) {
      $leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"));
      //$leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"))->where("nome", "NOT LIKE", "%test%")->where("email", "NOT LIKE", "%test%");
      $validados = $leads->where("validado", "1")->count();
      $naoValidados = $leads->where("validado", "0")->count();

      return response()->json([
        'success' => true,
        'data' => array(
          'total' => $leads->count(),
          'validados' => $validados,
          'naovalidados' => $naoValidados
        )
      ], 200);
    }

    return response()->json(['success' => false, 'error' => 'token inválido'], 500);
  }

  public function vouchersDetalhes(Request $request) {
    date_default_timezone_set('America/Sao_Paulo');

    $user = User::where('token', $request->token)->first();
    if (isset($request->token) && !empty($request->token) && $user) {
      $hoje = date("Y-m-d H:i:s");

      $leads = $user->unidade->leads->where("data_voucher", ">=", $request->dataDe)->where("data_voucher", "<=", $request->dataAte);

      $promocoes = $user->unidade->promocoes->where('dataInicio', '<=', $hoje)
        ->where("dataFim", '>', $hoje)
        ->where("mostrar", "1")
        ->where("status", "1");

      $leadsFormatados = [];

      foreach ($leads as $key => $item) {
        $lead = [
          "id" => $item->id,
          "unidade_id" => $item->unidade_id,
          "promocao_id" => $item->promocao_id,
          "nome" => $item->nome,
          "email" => $item->email,
          "telefone" => $item->telefone,
          "voucher" => $item->voucher,
          "data_voucher" => $item->data_voucher,
          "horario_voucher" => $item->horario_voucher,
          "validado" => $item->validado,
        ];

        array_push($leadsFormatados, $lead);
      }


      return response()->json([
        'success' => true,
        'data' => array(
          'leads' => $leadsFormatados,
          'promocoes' => $promocoes,
        )
      ], 200);
    }

    return response()->json(['success' => false, 'error' => 'token inválido'], 500);
  }

  public function validar(Request $request) {
    date_default_timezone_set('America/Sao_Paulo');
    //apiLogin eh um helper
    $user = User::where('token', $request->token)->first();
    if (isset($request->token) && !empty($request->token) && isset($request->voucher) && !empty($request->voucher) && $user) {
      $lead = Lead::where("voucher", $request->voucher)->first();
      if ($lead->unidade->cliente_id == $user->cliente_id) {
        if ($lead->validado == "0") {
          $lead->validado = "1";
          if (isset($request->ferramenta_validacao) && !empty($request->ferramenta_validacao) && is_string($request->ferramenta_validacao)) {
            $lead->ferramenta_validacao = $request->ferramenta_validacao;
          }
          if ($lead->save()) {
            $leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"));
            //$leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"))->where("nome", "NOT LIKE", "%test%")->where("email", "NOT LIKE", "%test%");
            $validados = $leads->where("validado", "1")->count();
            $naoValidados = $leads->where("validado", "0")->count();

            return response()->json([
              'success' => true,
              'data' => array(
                "mensagem" => "voucher validado com sucesso",
                'total' => $leads->count(),
                'validados' => $validados,
                'naovalidados' => $naoValidados
              )
            ], 200);
          } else {
            return response()->json(['success' => false, 'error' => 'erro ao validar voucher'], 500);
          }
        } else {
          $leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"));
          //$leads = $user->unidade->leads->where("data_voucher", date("Y-m-d"))->where("nome", "NOT LIKE", "%test%")->where("email", "NOT LIKE", "%test%");
          $validados = $leads->where("validado", "1")->count();
          $naoValidados = $leads->where("validado", "0")->count();

          return response()->json([
            'success' => false,
            'error' => 'voucher já validado',
            'data' => array(
              'total' => $leads->count(),
              'validados' => $validados,
              'naovalidados' => $naoValidados
            )
          ], 500);
        }
      } else {
        return response()->json(['success' => false, 'error' => 'voucher inválido'], 500);
      }
    }

    return response()->json(['success' => false, 'error' => 'token inválido'], 500);
  }

  // Funcões de disparo de e-mail
  public function sendMailLeadAgendamento($lead, $promocao, $unidade, $dia, $periodo) {
    // date_default_timezone_set('America/Sao_Paulo');
    // $hoje = date("Y-m-d H:i:s");
    // $horaCron = date("Y-m-d 09:00:00");
    // $dataHoje = date("Y-m-d");
    // $dataVoucher = $lead->data_voucher;

    //Verifica se sera necessario preencher origem
    if (empty($lead->origem)) {
      $lead->origem = "P9/Nao Identificado";
    }

    if (config('app.env') === "production") {
      Mail::to(['notificacaoleads@p9.digital'])
        ->queue(new Agendamento($lead, $promocao, $unidade, $dia, $periodo));
    } else {
      Mail::to(['teste@p9.digital'])
        ->queue(new Agendamento($lead, $promocao, $unidade, $dia, $periodo));
    }

    //dispara sms para o usuario
    // if($horaCron < $hoje && $dataHoje == $dataVoucher) {
    //     \App\Jobs\SmsAviso::dispatch($lead, $promocao)->delay(now()->addMinutes(10));
    // }
  }

  public function sendMailLeadAgendamentoPesquisa($lead, $promocao, $unidade, $dia, $periodo) {
    //Verifica se sera necessario preencher origem
    if (empty($lead->origem)) {
      $lead->origem = "P9/Nao Identificado";
    }

    if (config('app.env') === "production") {
      Mail::to(['notificacaoleads@p9.digital'])
        ->queue(new AgendamentoPesquisa($lead, $promocao, $unidade, $dia, $periodo));
    } else {
      Mail::to(['teste@p9.digital'])
        ->queue(new AgendamentoPesquisa($lead, $promocao, $unidade, $dia, $periodo));
    }
  }

  public function sendMailVoucher($lead, $promocao, $unidade, $dia, $periodo) {
    //disparar email para o franqueado/franqueadora
    Mail::to([$lead->email])
      ->queue(new \App\Mail\Voucher($lead, $promocao, $unidade, $dia, $periodo));
  }

  // Função de criar o voucher
  public function storeVoucher(Request $request) {
    date_default_timezone_set('America/Sao_Paulo');
    $lead = new Lead($request->all());
    $diasMais = date_create('+21 day')->format('Y-m-d');

    $cli = $lead->promocao->cliente;
    $promo = $lead->promocao;

    $desabilitados = $promo->promocaounidades->where('unidade_id', $lead->unidade_id)->first()->desabilitados;
    $diasDesabilitados = array();

    foreach ($desabilitados as $desabilitado) {
      array_push($diasDesabilitados, $desabilitado->dia);
    }

    // if(
    //     $lead->data_voucher <= $diasMais &&
    //     $lead->data_voucher <= $promo["dataFim"] &&
    //     !in_array($lead->data_voucher, $diasDesabilitados) &&
    //     count($promo->leads->where('unidade_id', $lead->unidade_id)->where('data_voucher', $lead->data_voucher)) < $promo->limite
    // ) {
    // Código if abaixo específico limite aumentado promoção dipz artur alvim
    $dataLimite = "2021-03-04";
    if (
      $lead->data_voucher <= $diasMais &&
      $lead->data_voucher <= $promo["dataFim"] &&
      !in_array($lead->data_voucher, $diasDesabilitados) &&
      (
        count($promo->leads->where('unidade_id', $lead->unidade_id)->where('data_voucher', $lead->data_voucher)) < $promo->limite ||
        ($promo->id = 37 && $dataLimite == $lead->data_voucher && count($promo->leads->where('unidade_id', $lead->unidade_id)->where('data_voucher', $lead->data_voucher)) < ($promo->limite + 100))
      ) && (
        !$promo->limite_vouchers ||
        ($promo->limite_vouchers && $promo->limite_vouchers - count($promo->leads) > 0)
      )
    ) {

      //pega o ip do lead
      // $lead->ip = $_SERVER['REMOTE_ADDR'];
      $lead->hash = sha1($promo->id . $lead->email . date("Y-m-d H:i:s"));
      $existe = Lead::where(["promocao_id" => $lead->promocao_id, "unidade_id" => $lead->unidade_id, "data_voucher" => $lead->data_voucher, "email" => $lead->email])->first();

      if (!$existe) {
        //salva o lead no banco

        if (!$lead->save()) {
          //log de erro
          Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
        }

        $lead->voucher = $promo->codigo . $lead->id;

        if (!$lead->save()) {
          Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
        }

        $date = date('d/m/Y', strtotime($lead->data_voucher));
        $lead->dia = $date;

        $unidade = $lead->unidade;
        $per = $lead->periodo;

        /**
         * Decidir ainda como será a parte de E-mail
         */

        // try {
        //     $lead->notify(new \App\Notifications\Lead($lead));
        // } catch(Exception $e) {
        //     Log::error("Erro ao enviar notificação para slack", ["nome" => $lead->nome, "email" => $lead->email]);
        // }

        $this->sendMailLeadAgendamento($lead, $promo, $unidade, $date, $per->nome);
        $this->sendMailVoucher($lead, $promo, $unidade, $date, $per->nome);

        return response()->json([
          'success' => true,
          'data' => $lead,
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'data' => 'leadcriado',
        ], 200);
      }
    } else {
      return response()->json([
        'success' => false,
        'data' => 'Data indisponivel para agendamento',
      ], 200);
    }
  }

  // Função de criar o voucher
  public function storeVoucherPesquisa(Request $request) {
    date_default_timezone_set('America/Sao_Paulo');
    $lead = new Lead($request->all());
    $promo = $lead->promocao;

    if (
      $lead->data_voucher <= $promo["dataFim"] &&
      count($promo->leads->where('unidade_id', $lead->unidade_id)->where('data_voucher', $lead->data_voucher)) < $promo->limite &&
      (
        !$promo->limite_vouchers ||
        ($promo->limite_vouchers && $promo->limite_vouchers - count($promo->leads) > 0)
      )
    ) {
      //pega o ip do lead
      // $lead->ip = $_SERVER['REMOTE_ADDR'];
      $lead->hash = sha1($promo->id . $lead->email . date("Y-m-d H:i:s"));
      //***Não excluir***salva o lead no banco para gerar o id
      if (!$lead->save()) {
        //log de erro
        Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
      }

      $lead->voucher = $promo->codigo . $lead->id;
      //atualiza o voucher com o id gerado
      if (!$lead->save()) {
        Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
      }

      //Salva respostas da pesquisa
      try {
        $pesquisaCriada = Pesquisa::create([
          "lead_id" => $lead->id,
          "promocao_id" => $request->promocao_id,
          "unidade_id" => $request->unidade_id,
          "pesquisas" => $request->pesquisas,
          "respostas" => $request->respostas
        ]);

        $lead["pesquisa"] = $pesquisaCriada;
      } catch (\Exception $e) {
        Log::error($e->getMessage());
      }

      $date = date('d/m/Y', strtotime($lead->data_voucher));
      $lead->dia = $date;

      $unidade = $lead->unidade;
      $per = $lead->periodo;

      $this->sendMailLeadAgendamentoPesquisa($lead, $promo, $unidade, $date, $per->nome);
      Mail::to([$lead->email])
        ->queue(new \App\Mail\Pesquisa($lead, $promo, $unidade, $date, $per->nome));

      return response()->json([
        'success' => true,
        'data' => $lead,
      ], 200);
    } else {
      return response()->json([
        'success' => false,
        'data' => 'Data indisponivel para agendamento',
      ], 200);
    }
  }

  public function verificaLimitePorEmailOuCelular(Request $request) {
    $leads = Lead::where("promocao_id", $request->promocao_id)->where($request->campo, $request->valor)->get();

    return response()->json([
      'success' => true,
      'data' => $leads->count()
    ], 200);
  }

  public function verificaLimitePorCPFPesquisa(Request $request) {
    $hojeInicio = date("Y-m-01");
    $hojeFim = date("Y-m-01", strtotime("+1 month", strtotime($hojeInicio)));
    $leads = Lead::where("promocao_id", $request->promocao_id)->where("cpf", $request->cpf)->where("data_voucher", ">", $hojeInicio)->where("data_voucher", "<", $hojeFim)->get();

    return response()->json([
      'success' => true,
      'data' => $leads->count()
    ], 200);
  }
}
