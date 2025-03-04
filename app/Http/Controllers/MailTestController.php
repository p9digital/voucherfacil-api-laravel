<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Contato;
use App\Models\Lead;
use App\Models\Promocao;
use App\Models\Unidade;

class MailTestController extends Controller {

  public function lead($id) {
    $leads = Lead::all();
    $lead = Lead::find($leads->last()->id);
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $lead->data = date("d/m/Y H:i:s");
    $promocao = Promocao::find($lead->promocao_id);
    return new \App\Mail\Lead($lead, $promocao);
  }

  public function agendamento($id) {
    $leads = Lead::all();
    $lead = Lead::find($leads->last()->id);
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $lead->data = date("d/m/Y H:i:s");
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);

    return new \App\Mail\Agendamento($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }

  public function voucher($id) {
    $leads = Lead::all();
    $lead = Lead::find($leads->last()->id);
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);
    return new \App\Mail\Voucher($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }

  public function contato($id) {
    $contatos = Contato::all();
    $contato = Contato::find($contatos->last()->id);
    if ($id > 0) {
      $contato = Contato::find($id);
    }
    return new \App\Mail\Contato($contato);
  }

  public function aviso($id) {
    $leads = Lead::all();
    $lead = Lead::find($leads->last()->id);
    if ($id > 0) {
      $lead = Lead::find($id);
    }
    $date = date('d/m/Y', strtotime($lead->data_voucher));
    $lead->dia = $date;
    $promocao = Promocao::find($lead->promocao_id);
    $unidade = Unidade::find($lead->unidade_id);
    return new \App\Mail\Aviso($lead, $promocao, $unidade, $lead->dia, $lead->periodo->nome);
  }

  public function smsAviso($sms = false, $email = false) {
    Log::info('Cron job manual executado' . date("Y-m-d H:i:s"));

    date_default_timezone_set('America/Sao_Paulo');
    $hoje = date("Y-m-d");
    if ($hoje != "2018-06-12") {
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
  }
}
