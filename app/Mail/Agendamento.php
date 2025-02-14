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

class Agendamento extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Lead $agendamento,
        protected Promocao $promocao,
        protected Unidade $unidade,
        protected $dia,
        protected $periodo
    ) {
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
