<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class Aviso extends Mailable {
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $promocao;
  public $unidade;
  public $voucher;
  public $dia;
  public $periodo;

  public function __construct($voucher, $promocao, $unidade, $dia, $periodo) {
    $this->promocao = $promocao;
    $this->unidade = $unidade;
    $this->voucher = $voucher;
    $this->dia = $dia;
    $this->periodo = $periodo;
  }

  /**
   * Get the message envelope.
   */
  public function envelope() {
    return new Envelope(
      subject: $this->voucher->nome . ', hoje é seu dia no ' . $this->unidade->cliente->razaoSocial . '!',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content() {
    return new Content(
      markdown: 'mail.aviso',
      with: [
        'promocao' => $this->promocao,
        'unidade' => $this->unidade,
        'voucher' => $this->voucher,
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
