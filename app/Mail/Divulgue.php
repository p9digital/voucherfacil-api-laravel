<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class Divulgue extends Mailable {
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $divulgue;

  public function __construct($divulgue) {
    $this->divulgue = $divulgue;
  }

  /**
   * Get the message envelope.
   */
  public function envelope() {
    return new Envelope(
      subject: '[Voucher Fácil] Divulgue sua Empresa',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content() {
    return new Content(
      markdown: 'mail.divulgue',
      with: [
        'divulgue' => $this->divulgue,
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
