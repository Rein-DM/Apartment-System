<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Specify 'mail' to send the notification via email
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Please Verify Your Email Address')
            ->line('Thank you for signing up! Please verify your email address.')
            ->action('Verify Email Address', $this->verificationUrl($notifiable))
            ->line('If you did not create an account, no further action is required.')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the verification URL for the user.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
{
    return URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60), 
        [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]
    );
}


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            // Optionally, you can add any additional data here
        ];
    }
}
