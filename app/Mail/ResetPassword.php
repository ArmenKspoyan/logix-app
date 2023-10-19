<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {

        $user['token'] = $this->token;
        return $this
            ->subject('Password Reset Link')
            ->view('reset-password', [
                'url' => sprintf('%s/settings/password/change?token=%s&email=%s',
                    config('app.spa_url'), $user['token'], auth()->user()->email)
            ]);
    }
}
