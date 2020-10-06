<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceChangeNotification extends Notification
{
    use Queueable;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Price of a moving has been set')
                    ->line('Here is your price: $' . $this->model->price)
                    ->action('Pay Now', route('admin.movings.show', $this->model))
                    ->line('Thank you for using our application!');
    }
}
