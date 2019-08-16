<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $adminName;
    public $newCandidatesCount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($adminName, $newCandidatesCount)
    {
        $this->adminName = $adminName;
        $this->newCandidatesCount = $newCandidatesCount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.notify-admin');
    }
}
