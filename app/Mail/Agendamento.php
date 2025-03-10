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
  public $lead;
  public $promocao;
  public $unidade;
  public $periodo;
  public $dia;

  public function __construct($lead, $dia) {
    $this->lead = $lead;
    $this->promocao = $lead->promocao;
    $this->unidade = $lead->unidade;
    $this->periodo = $lead->periodo->nome;
    $this->dia = $dia;
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
        'lead' => $this->lead,
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
