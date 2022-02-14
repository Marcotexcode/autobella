<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class OrdineSpedito extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param  \App\Models\OrdineRiga  $riga
     * 
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.mail.ordine.spedito');
    }
}
