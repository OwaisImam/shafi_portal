<?php

namespace App\Notifications;

use App\Constants\DefaultValues;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomPasswordReset extends ResetPassword
{
    use Queueable;

    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {

        $params = [
                '#Link#' => url(config('app.url') . route('client.password.reset', ['token' => $this->token], false)),
                '#Year#' => date('Y'),
              ];

        $content = DefaultValues::prepareEmailBody('forgot_password', $params);

        return (new MailMessage())
        ->subject($content['subject'])
        ->markdown('emails.client.forgot_password', ['content' => $content['content']]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
