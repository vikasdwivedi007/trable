<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderNotification extends Notification
{
    use Queueable;

    public $reminder;
    public $popup;

    /**
     * Create a new notification instance.
     *
     * @param $reminder
     * @param bool $popup
     */
    public function __construct($reminder, $popup = false)
    {
        $this->reminder = $reminder;
        $this->popup = $popup;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'type' => 'reminder',
            'reminder_id' => $this->reminder->id,
            'title' => $this->reminder->title,
            'content' => $this->reminder->desc,
            'popup' => $this->popup
        ];
    }
}
