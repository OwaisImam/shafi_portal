<?php

namespace App\Mail;

use App\Constants\DefaultValues;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientLoginCredentials extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $client;
    private $string;
    /**
     * Create a new message instance.
     */
    public function __construct($client, $string)
    {
        $this->client = $client;
        $this->string = $string;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Client Login Credentials',
        );
    }

    /**
     * Get the message content definition.
     */

    public function build()
    {
        $params = [
           '#ClientName#' => $this->client->getName(),
           '#LoginLink#' => route('login'),
           '#Year#' => date('Y'),
           '#Password#' => $this->string,
           '#Email#' => $this->client->email,
        ];

        $content = DefaultValues::prepareEmailBody('client_login_credentials', $params);

        return $this->subject($content['subject'])
        ->from(
            env('MAIL_FROM_ADDRESS'),
            env('MAIL_FROM_NAME')
        )->cc(env('MAIL_CC_ADDRESS'))->html($content['content']);
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
}
