<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Pesquisa;
use App\Models\Promocao;
use LaravelQRCode\Facades\QRCode;

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
    $promocao = Promocao::find($request->promocao_id);

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

      // try {
      //     $lead->notify(new \App\Notifications\Lead($lead));
      // } catch(Exception $e) {
      //     Log::error("Erro ao enviar notificação para slack", ["nome" => $lead->nome, "email" => $lead->email]);
      // }

      $this->sendMailLeadAgendamento($lead, $date);
      $this->sendMailVoucher($lead, $date);

      return response()->json(['data' => $lead]);
    } else {
      return response()->json(['error' => 'Data indisponível para agendamento'], 500);
    }
  }

  public function verificaLimitePorEmailOuCelular(Request $request) {
    $leads = Lead::where("promocao_id", $request->promocao_id)->where($request->campo, $request->valor)->get();

    return response()->json(['data' => $leads->count()]);
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

      $this->sendMailLeadAgendamentoPesquisa($lead, $date);
      Mail::to([$lead->email])
        ->queue(new \App\Mail\Pesquisa($lead, $date));

      return response()->json(['data' => $lead]);
    } else {
      return response()->json(['error' => 'Data indisponível para agendamento']);
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

    return response()->json(['data' => $leads->count()]);
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
  private function sendMailLeadAgendamento($lead, $dia) {
    // $hoje = date("Y-m-d H:i:s");
    // $horaCron = date("Y-m-d 08:00:00");
    // $dataHoje = date("Y-m-d");
    // $dataVoucher = $lead->data_voucher;

    //Verifica se sera necessario preencher origem
    if (empty($lead->origem)) {
      $lead->origem = "P9/Nao Identificado";
    }

    if (config('app.env') === "production") {
      Mail::to(['notificacaoleads@p9.digital'])
        ->queue(new \App\Mail\Agendamento($lead, $dia));
    } else {
      Mail::to(['dev@p9.digital'])
        ->queue(new \App\Mail\Agendamento($lead, $dia));
    }

    //dispara sms para o usuario
    // if($horaCron < $hoje && $dataHoje == $dataVoucher) {
    //     \App\Jobs\SmsAviso::dispatch($lead, $promocao)->delay(now()->addMinutes(10));
    // }
  }

  private function sendMailLeadAgendamentoPesquisa($lead, $dia) {
    //Verifica se sera necessario preencher origem
    if (empty($lead->origem)) {
      $lead->origem = "P9/Nao Identificado";
    }

    if (config('app.env') === "production") {
      Mail::to(['notificacaoleads@p9.digital'])
        ->queue(new \App\Mail\Pesquisa($lead, $dia));
    } else {
      Mail::to(['dev@p9.digital'])
        ->queue(new \App\Mail\Pesquisa($lead, $dia));
    }
  }

  private function sendMailVoucher($lead, $dia) {
    //disparar email para o franqueado/franqueadora
    $path = storage_path("app/public/" . $lead->voucher . ".png");
    QRCode::url(env("ADMIN_URL") . "/validar/$lead->voucher")->setSize(200)->setOutfile($path)->png();

    Mail::to([$lead->email])
      ->queue(new \App\Mail\Voucher($lead, $dia));
  }

  // OLD Actions
  // public function reagendamento($cliente, $promocao, $hash) {
  //   $lead = Lead::where('hash', $hash)->first();
  //   if (empty($lead->voucher)) {
  //     $cli = Cliente::where('path', $cliente)->firstOrFail();
  //     $promo = Promocao::where('path', $promocao)->where("cliente_id", $cli->id)->firstOrFail();
  //     $diasDesabilitados = DB::select("SELECT DISTINCT(data_voucher) AS dv, (SELECT COUNT(*) FROM leads l WHERE l.unidade_id = $lead->unidade_id AND l.promocao_id = $lead->promocao_id AND l.data_voucher = dv) AS count FROM leads WHERE unidade_id = $lead->unidade_id AND promocao_id = $lead->promocao_id");

  //     return view('agendamento.reagendamento', ['lead' => $lead, 'nome' => $lead->nome, 'cliente' => $cli, 'promocao' => $promo, 'diasDesabilitados' => $diasDesabilitados]);
  //   } else {
  //     return redirect($cliente . "/" . $promocao)->withErrors(["nome" => "Agendamento já realizado."]);
  //   }
  // }

  // public function calendario($cliente, $promocao, $idlead) {
  //   header("Content-Type: text/calendar; charset=utf-8");
  //   header("Content-Disposition: attachment; filename=calendario.ics");
  //   $lead = Lead::find($idlead);
  //   $cli = Cliente::where('path', $cliente)->firstOrFail();
  //   $promo = Promocao::where('path', $promocao)->where("cliente_id", $cli->id)->firstOrFail();
  //   $periodo = str_replace(":", "", $lead->periodo->nome);

  //   $name = "Promoção " . $promo->titulo;
  //   $data = str_replace("-", "", $lead->data_voucher);
  //   $location = $lead->unidade->endereco . ", " . $lead->unidade->numero . ", " . $lead->unidade->bairro . (!empty($lead->unidade->complemento) ? ", " . $lead->unidade->complemento : "") . ", " . $lead->unidade->cidade->nome . "-" . $lead->unidade->estado->uf;
  //   $start = $data . "T{$periodo}00Z";
  //   $end = $data . "T{$periodo}00Z";
  //   $description = "descrição";
  //   $slug = strtolower(str_replace(array(' ', "'", '.'), array('_', '', ''), $name));
  //   $texto = "";
  //   echo "BEGIN:VCALENDAR\n";
  //   echo "VERSION:2.0\n";
  //   echo "PRODID:-//VoucherFacil.com.br//NONSGML " . "//EN\n";
  //   echo "METHOD:REQUEST\n";
  //   echo "BEGIN:VEVENT\n";
  //   echo "UID:" . $data . "T{$periodo}00-" . rand() . "-voucherfacil.com.br\n"; //Required by Outlook
  //   echo "DTSTAMP:" . $data . "T{$periodo}00\n";
  //   echo "DTSTART;TZID=America/Sao_Paulo:" . $start . "\n";
  //   echo "DTEND;TZID=America/Sao_Paulo:" . $end . "\n";
  //   echo "LOCATION:" . $location . "\n";
  //   echo "SUMMARY:" . $name . "\n";
  //   echo "DESCRIPTION:" . $description . "\n";
  //   echo "END:VEVENT\n";
  //   echo "END:VCALENDAR";
  //   return;
  // }

  // public function pdf($cliente, $promocao, $voucher) {
  //   $lead = Lead::where('voucher', $voucher)->first();
  //   if ($lead) {
  //     $data = date("d/m/Y", strtotime($lead->data_voucher));

  //     return \PDF::loadView('voucher.voucher', ['lead' => $lead, 'cliente' => $lead->promocao->cliente, 'promocao' => $lead->promocao, 'data' => $data, 'unidade' => $lead->unidade])->download('pdfvoucher.pdf');
  //   } else {
  //     return redirect(url());
  //   }
  // }
}
