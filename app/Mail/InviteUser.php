<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ref_code;
    public $role_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ref_code, $role_name)
    {
          $this->ref_code   = $ref_code;
          $this->role_name  = $role_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation to join '. settings('company_name') )
                    ->markdown('emails.invite');
    }
}
