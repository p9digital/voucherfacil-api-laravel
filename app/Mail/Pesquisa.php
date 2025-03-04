<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Lead;
use App\Models\Promocao;
use App\Models\Unidade;

class Pesquisa extends Mailable {
  use Queueable, SerializesModels;

  public $agendamento;
  public $promocao;
  public $respostas;
  public $unidade;
  public $dia;
  public $periodo;

  /**
   * Create a new message instance.
   */
  public function __construct($agendamento, $promocao, $unidade, $dia, $periodo) {
    $this->agendamento = $agendamento;
    $this->promocao = $promocao;
    $this->unidade = $unidade;
    $this->dia = $dia;
    $this->periodo = $periodo;

    $pesquisa = $agendamento->pesquisa;
    $this->respostas = array();
    $pesquisas = json_decode($pesquisa->pesquisas);
    $respostas = json_decode($pesquisa->respostas);
    for ($i = 0; $i < count($pesquisas); $i++) {
      $this->respostas[$i] = array("id" => $i + 1, "pergunta" => $pesquisas[$i]->pergunta, "resposta" => $respostas->{$i});
    }
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope {
    return new Envelope(
      subject: $this->agendamento->nome . ', o número do seu Voucher Fácil no ' . $this->unidade->cliente->razaoSocial . '!',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content {
    return new Content(
      markdown: 'mail.pesquisa',
      with: [
        'agendamento' => $this->agendamento,
        'promocao' => $this->promocao,
        'unidade' => $this->unidade,
        'dia' => $this->dia,
        'periodo' => $this->periodo,
        'respostas' => $this->respostas,
      ],
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array {
    return [];
  }
}
