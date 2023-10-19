<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public array $data
    )
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->subject('Change email')
            ->view('change-email', [
                'url' => sprintf('%s/settings/change-email?token=%s&email=%s', config('app.spa_url'),
                    $this->data['token'], $this->data['email'])
            ]);
    }
}
