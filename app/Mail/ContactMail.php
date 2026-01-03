<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
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
        return $this->subject('【お問い合わせ】' . $this->data['subject'])
            ->markdown('emails.contact')
            ->with([
                'name' => $this->data['name'],
                'email' => $this->data['email'],
                'subject' => $this->data['subject'],
                'message' => $this->data['message'],
            ]);
    }
}

