<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this
               ->subject('Envio de Comprobante')
               ->view('mail.message_voucher')
               ->attachData($this->pdf->output(), 'comprobante.pdf');
    }
}
