<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegistered extends VerifyEmail
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('Confirma tu correo | F&F')
            ->view('mailings.01-registro',['user' => $this->user, 'verification_url' => $this->verificationUrl($notifiable)]);
    }
}
