<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Pesquisa extends Mailable {
  use Queueable, SerializesModels;

  public $lead;
  public $promocao;
  public $unidade;
  public $periodo;
  public $respostas;
  public $dia;

  /**
   * Create a new message instance.
   */
  public function __construct($lead, $dia) {
    $this->lead = $lead;
    $this->promocao = $lead->promocao;
    $this->unidade = $lead->unidade;
    $this->periodo = $lead->periodo->nome;
    $this->dia = $dia;

    $pesquisa = $lead->pesquisa;
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
      subject: $this->lead->nome . ', o número do seu Voucher Fácil no ' . $this->unidade->cliente->razaoSocial . '!',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content {
    return new Content(
      markdown: 'mail.pesquisa',
      with: [
        'lead' => $this->lead,
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
