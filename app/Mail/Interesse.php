<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Interesse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $interesse;
    public $promocao;

    public function __construct($interesse, $promocao)
    {
        $this->interesse = $interesse;
        $this->promocao = $promocao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[Voucher Fácil] Novo Interesse')
            ->markdown('emails.interesse');
    }
}
