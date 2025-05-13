<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MessageReceived extends Notification
{
    public $fromUser;

    public function __construct($fromUser)
    {
        $this->fromUser = $fromUser;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Envoi par email et sauvegarde dans la base de données
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Vous avez reçu un message de ' . $this->fromUser->name,
            'from_user_id' => $this->fromUser->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Vous avez reçu un message de ' . $this->fromUser->name)
            ->action('Voir le message', url('/messages/' . $this->fromUser->id));
    }
}

