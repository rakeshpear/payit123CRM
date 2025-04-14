<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $fileName;
    public $company_name;
    public $uploadLink;
    public function __construct($company_name, $fileName, $uploadLink)
    {
        $this->company_name = $company_name;
        $this->fileName = $fileName;
        $this->uploadLink = $uploadLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contract Document from PayIT123 - Regarding',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail_template.contract-email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->fileName) {
            $attachments = [

                Attachment::fromPath(public_path('/contracts/' . $this->fileName))
            ];
        }
        return $attachments;
    }
}
