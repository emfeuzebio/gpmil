<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TrocaDeSecaoNotification extends Notification
{
    use Queueable;
    private $user;
    private $motivo;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $motivo)
    {
        $this->user = $user;
        $this->motivo = $motivo;

        // Buscando o nome_guerra e pgrad_sigla do usuário
        $pessoa = $this->user->pessoa;
        $this->user->nome_guerra = $pessoa->nome_guerra;
        $this->user->pgrad_sigla = $pessoa->pgrad->sigla;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra,
            'secao' => $this->motivo,
            'message' => 'O ' . $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra . ' pediu para ser trocado para a seção de ' . $this->motivo . '.',
        ];
    }    
}
