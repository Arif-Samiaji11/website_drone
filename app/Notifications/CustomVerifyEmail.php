<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $verifyUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email - Mriki Project')
            ->view('emails.verify-email', [
                'name' => $notifiable->name ?? 'Kak',
                'verifyUrl' => $verifyUrl,
            ]);
    }
}
