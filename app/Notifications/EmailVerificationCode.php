<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationCode extends Notification
{
    use Queueable;

    public function __construct(public string $code) {}

    /**
     * Get the notification channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Dorm Portal email verification code')
            ->greeting('Verify your email address')
            ->line('Enter this code in Dorm Portal to confirm you own this email address:')
            ->line($this->code)
            ->line('This code expires in 10 minutes. If you did not request it, you can ignore this message.');
    }
}
