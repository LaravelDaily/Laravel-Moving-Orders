<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MovingPaidNotification extends Notification
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
                    ->line('Moving #' . $this->model->id . ' has been paid')
                    ->action('See Moving', route('admin.movings.show', $this->model));
    }
}
