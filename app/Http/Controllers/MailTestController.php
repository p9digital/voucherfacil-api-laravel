<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Contato;
use App\Models\Empresa;
use App\Models\Interesse;
use App\Models\Lead;
use App\Models\Promocao;
use App\Models\Unidade;

class MailTestController extends Controller {

  public function agendamento($id = null) {
    $lead = Lead::whereHas("promocao", function ($query) {
      $query->where("pesquisa", "0");
    })->get()->last();
    if ($id > 0) {
      $lead = Lead::whereHas("promocao", function ($query) {
        $query->where("pesquisa", "1");
      })->where("id", $id)->first();
    }
    if (!$lead) return "Não encontrado";

    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $lead->data = date("d/m/Y H:i:s");
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);

    return new \App\Mail\Agendamento($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }

  public function aviso($id = null) {
    $lead = Lead::all()->last();
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    if (!$lead) return "Não encontrado";

    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);
    return new \App\Mail\Aviso($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }

  public function contato($id = null) {
    $contato = Contato::all()->last();
    if ($id > 0) {
      $contato = Contato::find($id);
    }
    return new \App\Mail\Contato($contato);
  }

  public function divulgue($id = null) {
    $divulgue = Empresa::all()->last();
    if ($id > 0) {
      $divulgue = Empresa::find($id);
    }
    return new \App\Mail\Divulgue($divulgue);
  }

  public function interesse($id = null) {
    $interesse = Interesse::all()->last();
    if ($id > 0) {
      $interesse = Interesse::find($id);
    }
    $promocao = Promocao::find($interesse->promocao_id);
    return new \App\Mail\Interesse($interesse);
  }

  public function lead($id = null) {
    $lead = Lead::all()->last();
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $lead->data = date("d/m/Y H:i:s");
    $promocao = Promocao::find($lead->promocao_id);
    return new \App\Mail\Lead($lead, $promocao);
  }

  public function pesquisa($id = null) {
    $lead = Lead::with("pesquisa")->whereHas("promocao", function ($query) {
      $query->where("pesquisa", "1");
    })->get()->last();
    if ($id > 0) {
      $lead = Lead::with("pesquisa")->whereHas("promocao", function ($query) {
        $query->where("pesquisa", "1");
      })->where("id", $id)->first();
    }
    if (!$lead) return "Não encontrado";

    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $lead->data = date("d/m/Y H:i:s");
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);

    return new \App\Mail\Pesquisa($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }

  public function smsAviso($sms = false, $email = false) {
    date_default_timezone_set('America/Sao_Paulo');
    Log::info('Cron job de disparo de E-mail e/ou SMS manual executado');

    $hoje = date("Y-m-d");
    $leads = Lead::where("data_voucher", $hoje)->get();
    foreach ($leads as $lead) {
      $promocao = Promocao::find($lead->promocao_id);
      if ($sms !== false && $sms !== 'false') {
        Log::info('Enviando SMS para: ' . $lead->telefone);
        \App\Jobs\SmsAviso::dispatch($lead, $promocao);
        Log::info('SMS enviado para: ' . $lead->telefone);
      }

      if ($email !== false) {
        Log::info('Enviando e-mail para: ' . $lead->email);
        $date = date('d/m/Y', strtotime($lead->data_voucher));
        $lead->dia = $date;
        Mail::to([$lead->email])
          ->send(new \App\Mail\Aviso($lead, $promocao, $lead->unidade, $date, $lead->periodo->nome));
        Log::info('E-mail enviado para: ' . $lead->email);
      }
    }
  }

  public function voucher($id = null) {
    $lead = Lead::all()->last();
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);
    return new \App\Mail\Voucher($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }
}
