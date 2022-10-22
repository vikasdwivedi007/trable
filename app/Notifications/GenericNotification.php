<?php

namespace App\Notifications;

use App\Mail\GenericMail;
use App\Mail\ReminderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var bool
     */
    public $popup;
    public $title;
    public $desc;

    /**
     * Create a new notification instance.
     *
     * @param $title
     * @param $desc
     * @param bool $popup
     */
    public function __construct($title, $desc, $popup = true)
    {
        $this->title = $title;
        $this->desc = $desc;
        $this->popup = $popup;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return GenericMail
     */
    public function toMail($notifiable)
    {
        return (new GenericMail($this->title, $this->desc, $notifiable))->to($notifiable->email);
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
            'type' => 'generic',
            'title' => $this->title,
            'content' => $this->desc,
            'popup' => $this->popup
        ];
    }
}
