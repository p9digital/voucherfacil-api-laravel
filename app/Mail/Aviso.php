<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Aviso extends Mailable
{
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

    public function __construct($voucher, $promocao, $unidade, $dia, $periodo)
    {
        $this->promocao = $promocao;
        $this->unidade = $unidade;
        $this->voucher = $voucher;
        $this->dia = $dia;
        $this->periodo = $periodo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->voucher->nome . ', hoje é seu dia no ' . $this->unidade->cliente->razaoSocial . '!')
            ->markdown('emails.aviso');
    }
}
