<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    // 1. Deklarasikan variabel token agar bisa diakses di toMail()
    public $token;

    /**
     * Create a new notification instance.
     */
    // 2. Terima token saat notification ini dipanggil dari model User
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // 3. Hanya gunakan SATU method toMail()
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->view('emails.custom-reset-password', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset()
            ]);
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