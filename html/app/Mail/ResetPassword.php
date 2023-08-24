<?php

namespace App\Mail;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public $token;
    public $user;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('Reestablece tu contraseña | F&F')
            ->view('mailings.02-recuperar-contrasena',['url' => url('cambiar-contrasena', [$this->token, $this->user->email]), 'user' => $this->user]);
    }
}
