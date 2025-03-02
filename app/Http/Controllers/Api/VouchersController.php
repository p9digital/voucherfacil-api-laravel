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
  // Promoções Actions
  public function storeVoucher(Request $request) {
    $existe = Lead::where([
      "promocao_id" => $request->promocao_id,
      "unidade_id" => $request->unidade_id,
      "data_voucher" => $request->data_voucher,
      "email" => $request->email
    ])->first();

    if ($existe) {
      return response()->json(['error' => 'Voucher já cadastrado', 'existe' => true], 500);
    }

    $lead = new Lead($request->all());
    $promocao = $lead->promocao;

    $permiteGerarVoucher = $this->validacoesPromocao($request, $promocao);
    if ($permiteGerarVoucher) {
      // $lead->ip = $_SERVER['REMOTE_ADDR'];
      $lead->hash = sha1($promocao->id . $request->email . date("Y-m-d H:i:s"));
      if (!$lead->save()) {
        Log::error('Lead NÃO salvo', ['nome' => $request->nome, 'email' => $request->email, 'telefone' => $request->telefone]);
      }

      $lead->voucher = $promocao->codigo . $lead->id;
      if (!$lead->save()) {
        Log::error('Lead NÃO atualizado', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
      }

      $date = date('d/m/Y', strtotime($lead->data_voucher));
      $lead->dia = $date;
      $unidade = $lead->unidade;
      $per = $lead->periodo;

      // try {
      //     $lead->notify(new \App\Notifications\Lead($lead));
      // } catch(Exception $e) {
      //     Log::error("Erro ao enviar notificação para slack", ["nome" => $lead->nome, "email" => $lead->email]);
      // }

      $this->sendMailLeadAgendamento($lead, $promocao, $unidade, $date, $per->nome);
      $this->sendMailVoucher($lead, $promocao, $unidade, $date, $per->nome);

      return response()->json(['data' => $lead], 200);
    } else {
      return response()->json(['error' => 'Data indisponível para agendamento'], 500);
    }
  }

  public function verificaLimitePorEmailOuCelular(Request $request) {
    $leads = Lead::where("promocao_id", $request->promocao_id)->where($request->campo, $request->valor)->get();

    return response()->json(['data' => $leads->count()], 200);
  }

  private function validacoesPromocao($request, $promocao) {
    $diasMais = date_create('+21 day')->format('Y-m-d');
    $desabilitados = $promocao->promocaounidades->where('unidade_id', $request->unidade_id)->first()->desabilitados;
    $diasDesabilitados = array();
    foreach ($desabilitados as $desabilitado) {
      array_push($diasDesabilitados, $desabilitado->dia);
    }

    $vouchersGeradosNaUnidade = $promocao->leads->where(['unidade_id' => $request->unidade_id, 'data_voucher' => $request->data_voucher])->count();
    // Código abaixo específico limite aumentado promoção dipz artur alvim
    $dataLimite = "2021-03-04";
    $validacaoArthurAlvim = $promocao->id = 37
      && $dataLimite == $request->data_voucher
      && $vouchersGeradosNaUnidade < ($promocao->limite + 100);
    if (
      $request->data_voucher <= $diasMais // Não exceder 20 dias
      && $request->data_voucher <= $promocao["dataFim"] // Não exceder fim da promoção
      && !in_array($request->data_voucher, $diasDesabilitados) // Não escolheu dia desabilitado
      && (
        $vouchersGeradosNaUnidade < $promocao->limite // Não excedeu limite por unidade
        || $validacaoArthurAlvim // Validou condição especial Arthur Alvim
      )
      && (
        !$promocao->limite_vouchers
        || ($promocao->limite_vouchers && $promocao->limite_vouchers - $promocao->leads->count() > 0)
      ) // Verifica limite total de vouchers da promoção em todas as unidades
    )
      return true;
    return false;
  }

  // Pesquisa Actions
  public function storeVoucherPesquisa(Request $request) {
    $lead = new Lead($request->all());
    $promocao = $lead->promocao;

    $permiteGerarVoucher = $this->validacoesPesquisa($request, $promocao);
    if ($permiteGerarVoucher) {
      //pega o ip do lead
      // $lead->ip = $_SERVER['REMOTE_ADDR'];
      $lead->hash = sha1($promocao->id . $lead->email . date("Y-m-d H:i:s"));
      //***Não excluir***salva o lead no banco para gerar o id
      if (!$lead->save()) {
        Log::error('Lead NÃO salvo', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
      }

      $lead->voucher = $promocao->codigo . $lead->id;
      //atualiza o voucher com o id gerado
      if (!$lead->save()) {
        Log::error('Lead NÃO atualizado', ['nome' => $lead->nome, 'email' => $lead->email, 'telefone' => $lead->telefone]);
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

      $this->sendMailLeadAgendamentoPesquisa($lead, $promocao, $unidade, $date, $per->nome);
      Mail::to([$lead->email])
        ->queue(new \App\Mail\Pesquisa($lead, $promocao, $unidade, $date, $per->nome));

      return response()->json(['data' => $lead], 200);
    } else {
      return response()->json(['error' => 'Data indisponível para agendamento'], 200);
    }
  }

  public function verificaLimitePorCPFPesquisa(Request $request) {
    $hojeInicio = date("Y-m-01");
    $hojeFim = date("Y-m-01", strtotime("+1 month", strtotime($hojeInicio)));
    $leads = Lead::where("promocao_id", $request->promocao_id)
      ->where("cpf", $request->cpf)
      ->where("data_voucher", ">", $hojeInicio)
      ->where("data_voucher", "<", $hojeFim)
      ->get();

    return response()->json(['data' => $leads->count()], 200);
  }

  private function validacoesPesquisa($request, $promocao) {
    if (
      $request->data_voucher <= $promocao["dataFim"] // Não exceder fim da promoção
      && $promocao->leads->where(['unidade_id' => $request->unidade_id, 'data_voucher' => $request->data_voucher])->count() < $promocao->limite // Não excedeu limite por unidade
      && (
        !$promocao->limite_vouchers ||
        ($promocao->limite_vouchers && $promocao->limite_vouchers - $promocao->leads->count() > 0)
      ) // Verifica limite total de vouchers da promoção em todas as unidades
    )
      return true;
    return false;
  }

  // Funcões de disparo de e-mail
  private function sendMailLeadAgendamento($lead, $promocao, $unidade, $dia, $periodo) {
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

  private function sendMailLeadAgendamentoPesquisa($lead, $promocao, $unidade, $dia, $periodo) {
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

  private function sendMailVoucher($lead, $promocao, $unidade, $dia, $periodo) {
    //disparar email para o franqueado/franqueadora
    Mail::to([$lead->email])
      ->queue(new \App\Mail\Voucher($lead, $promocao, $unidade, $dia, $periodo));
  }

  // OLD API Rotas de dados
  public function leads(Request $request) {
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
}
