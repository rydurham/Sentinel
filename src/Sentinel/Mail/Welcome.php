<?php

namespace Sentinel\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email, $hash, $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $hash, $code)
    {
        $this->email = $email;
        $this->hash = $hash;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = config()->get('sentinel.subjects.welcome');
        $view = config()->get('sentinel.email.views.welcome', 'Sentinel::emails.welcome');

        return $this->from($this->gatherSenderAddress())
            ->subject($subject)
            ->view($view);
    }

    /**
     * If the application does not have a valid "from" address configured,
     * we should stub in a temporary alternative so we have something
     * to pass to the Mailer
     *
     * @return array|mixed
     */
    private function gatherSenderAddress()
    {
        $sender = config('mail.from', []);

        if (!array_key_exists('address', $sender) || is_null($sender['address'])) {
            return ['address' => 'noreply@example.com', 'name' => ''];
        }

        if (is_null($sender['name'])) {
            $sender['name'] = '';
        }

        return $sender;
    }
}
