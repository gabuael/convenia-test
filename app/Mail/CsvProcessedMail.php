<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CsvProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('CSV Processamento Completo')
            ->view('emails.csv_processed');
    }
}
