<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $subject)
    {
        $this->contact = $contact;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->replyTo($this->contact['email']) // Set the Reply-To address
                    ->from('no-reply@medsol.technology', $this->contact['name'])
                    ->bcc('wvcasumbal@medsol.technology') 
                    ->markdown('emails.contact');
    }
}
