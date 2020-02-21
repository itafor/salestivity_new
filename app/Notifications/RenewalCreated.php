<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RenewalCreated extends Notification
{
    use Queueable;
    protected $renewal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($renewal)
    {
        $this->renewal = $renewal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)

        ->greeting('Hello!')
                // ->line('One of your invoices has been paid!')
                // ->action('View Invoice', $url)
                // ->line('Thank you for using our application!');
                    ->view('emails.renewal_created_notification', ['renewal' => $this->renewal]);
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
            //
        ];
    }
}
