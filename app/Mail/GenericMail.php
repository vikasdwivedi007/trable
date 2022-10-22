<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $desc;
    public $notifiable;

    /**
     * Create a new message instance.
     *
     * @param $title
     * @param $desc
     * @param $notifiable
     */
    public function __construct($title, $desc, $notifiable)
    {
        $this->title = $title;
        $this->desc = $desc;
        $this->notifiable = $notifiable;
        $this->subject = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.employees.generic');
    }
}
