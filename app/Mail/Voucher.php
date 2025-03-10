<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class Voucher extends Mailable {
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $voucher;
  public $promocao;
  public $unidade;
  public $periodo;
  public $dia;

  public function __construct($voucher, $dia) {
    $this->voucher = $voucher;
    $this->promocao = $voucher->promocao;
    $this->unidade = $voucher->unidade;
    $this->periodo = $voucher->periodo;
    $this->dia = $dia;
  }

  /**
   * Get the message envelope.
   */
  public function envelope() {
    return new Envelope(
      subject: $this->voucher->nome . ', o número do seu Voucher Fácil no ' . $this->unidade->cliente->razaoSocial . '!',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content() {
    return new Content(
      markdown: 'mail.voucher',
      with: [
        'voucher' => $this->voucher,
        'promocao' => $this->promocao,
        'unidade' => $this->unidade,
        'dia' => $this->dia,
        'periodo' => $this->periodo->nome,
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
