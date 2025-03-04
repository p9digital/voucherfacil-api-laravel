<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class Contato extends Mailable {
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $contato;

  public function __construct($contato) {
    $this->contato = $contato;
  }

  /**
   * Get the message envelope.
   */
  public function envelope() {
    return new Envelope(
      subject: '[Voucher Fácil] Contato - ' . $this->contato->assunto,
    );
  }

  /**
   * Get the message content definition.
   */
  public function content() {
    return new Content(
      markdown: 'mail.contato',
      with: [
        'contato' => $this->contato,
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
