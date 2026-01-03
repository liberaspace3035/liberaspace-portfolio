<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('【Liberaspace】お問い合わせありがとうございます')
            ->markdown('emails.contact-confirmation')
            ->with([
                'name' => $this->data['name'],
                'subject' => $this->data['subject'],
                'message' => $this->data['message'],
            ]);
    }
}

