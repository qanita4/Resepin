<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    $url = url(route('password.reset', [
        'token' => $this->token,
        'email' => $notifiable->email,
    ], false));

    return (new MailMessage)
        ->subject('🔐 Reset Password - Resepin')
        ->view('mails.reset-password', [
            'url' => $url,
            'user' => $notifiable,
            'token' => $this->token
        ]);
}
}
