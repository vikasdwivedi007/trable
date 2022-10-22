<?php

namespace App\Jobs;

use App\Mail\ReminderMail;
use App\Notifications\ReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    public $reminder;

    /**
     * Create a new job instance.
     *
     * @param $reminder
     */
    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(in_array('mail', $this->reminder->send_by)){
            Mail::to($this->reminder->assigned_to->user->email)->queue(new ReminderMail($this->reminder));
            $this->reminder->assigned_to->user->notify(new ReminderNotification($this->reminder));
        }
        if(in_array('db', $this->reminder->send_by)){
            $this->reminder->assigned_to->user->notify(new ReminderNotification($this->reminder, true));
        }
    }
}
