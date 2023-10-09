<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class CreateOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

      public $logoUrl;
    public $personalInfo;
    public $order;
    public $orderItems;
    public $productUrl;
    public $assetsUrl;


    public function __construct($personalInfo, $order, $orderItems)
    {
        $this->logoUrl = Config::get('values.logo_url');
        $this->personalInfo = $personalInfo;
        $this->order = $order;
        $this->orderItems = $orderItems;
        $this->productUrl = Config::get('values.products_url');
        $this->assetsUrl = Config::get('values.assets_url');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Create Order',
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
        ->subject('Su pedido - '.Config::get('app.name'))
        ->view('mails.create-order');
    }
}
