<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Agendamento extends Mailable {
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public $promocao;
  public $unidade;
  public $agendamento;
  public $dia;
  public $periodo;

  public function __construct($agendamento, $promocao, $unidade, $dia, $periodo) {
    $this->agendamento = $agendamento;
    $this->promocao = $promocao;
    $this->unidade = $unidade;
    $this->dia = $dia;
    $this->periodo = $periodo;
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope {
    return new Envelope(
      subject: '[Voucher Fácil] Agendamento',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content {
    return new Content(
      markdown: 'mail.agendamento',
      with: [
        'agendamento' => $this->agendamento,
        'promocao' => $this->promocao,
        'unidade' => $this->unidade,
        'dia' => $this->dia,
        'periodo' => $this->periodo,
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
