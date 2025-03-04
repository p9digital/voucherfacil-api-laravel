<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class Lead extends Mailable {
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $lead;
  public $promocao;

  public function __construct($lead, $promocao) {
    $this->lead = $lead;
    $this->promocao = $promocao;
  }

  /**
   * Get the message envelope.
   */
  public function envelope() {
    return new Envelope(
      subject: '[Voucher Fácil] Novo Lead',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content() {
    return new Content(
      markdown: 'mail.lead',
      with: [
        'lead' => $this->lead,
        'promocao' => $this->promocao,
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
