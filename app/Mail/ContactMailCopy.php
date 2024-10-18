<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMailCopy extends Mailable
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
        return $this->subject('We received your inquiry: ' . $this->subject)
                    // ->replyTo('support@medsol.technology')
                    ->from('no-reply@medsol.technology', 'Medsol Support Team')
                    ->markdown('emails.contact_copy');
    }
}
