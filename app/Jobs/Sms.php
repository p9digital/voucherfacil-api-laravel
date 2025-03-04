<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class Sms implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   */
  public $lead;

  public function __construct($lead) {
    $this->lead = $lead;
  }

  /**
   * Execute the job.
   */
  public function handle() {
    Log::info('Start enviando SMS');

    try {
      //remove possiveis caracteres especiais
      $telefone = preg_replace('/[^0-9]+/i', '', $this->lead->telefone);

      //o numero precisa ser de celular e o horario de agendamento precisa estar preenchido
      if ((strlen($telefone) != 11) || (!$this->lead->data_voucher || empty($this->lead->data_voucher)))
        return 'nope';

      $dataVoucher = date('d/m/Y', strtotime($this->lead->data_voucher)); // data formatada 01/01 as 00:00
      $periodoVoucher = ($this->lead->promocao->id == 5 && in_array($this->lead->unidade->id, [2, 12]) ? 'por ordem de chegada' : str_replace("à", "a", $this->lead->periodo->nome));
      // $unidadeTelefone = (isset($this->lead->unidade->telefone) && filled($this->lead->unidade->telefone)) ? $this->lead->unidade->telefone : false;
      $corpo = "Agendado! Seu Voucher Fácil: {$this->lead->voucher} - {$dataVoucher} - {$periodoVoucher}. {$this->lead->promocao->cliente->razaoSocial} {$this->lead->unidade->nome} ({$this->lead->unidade->endereco}, {$this->lead->unidade->numero})";

      $client = new Client();

      $data = http_build_query(array(
        'operacao' => 'ENVIO',
        'usuario' => 'web@p9.digital.com.br',
        'senha' => 'p9digital',
        'tipo' => 'SMS',
        'destino' => "55{$telefone}", //precisa de codigo internacional
        'mensagem' => "{$corpo}",
        'rota' => 'PREMIO'
      ));

      Log::info('Enviando SMS: ' . $data);
      //chamada para a api
      $client->get("http://www.mmcenter.com.br/MMenvio.aspx?{$data}");
      Log::info('SMS enviado');
    } catch (Throwable $e) {
      Log::error('Erro ao enviar SMS: ' . $e->message);
    }
  }
}
