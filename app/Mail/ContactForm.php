<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $logoUrl;
    public $subject;
    public $name;
    public $email;
    public $contentMessage;


    public function __construct($subject,$name,$email,$contentMessage)
    {
       $this->logoUrl = Config::get('values.logo_url');
        $this->subject  = $subject;
        $this->name = $name;
        $this->email = $email;
        $this->contentMessage = $contentMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Form',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->from(Config::get('values.mail_from_reset_password'))
            ->subject('Nuevo mensaje desde la web')
            ->view('mails.contact-form');
    }
}
