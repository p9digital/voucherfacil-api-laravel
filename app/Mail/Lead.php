<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Lead extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $lead;
    public $promocao;

    public function __construct($lead, $promocao)
    {
        $this->lead = $lead;
        $this->promocao = $promocao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[Voucher Fácil] Novo Lead')
            ->markdown('emails.lead');
    }
}
