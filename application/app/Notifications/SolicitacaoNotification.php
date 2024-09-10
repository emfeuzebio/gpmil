<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class SolicitacaoNotification extends Notification
{
    use Queueable;
    private $user;
    private $motivo;
    private $tipo;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $motivo, $tipo)
    {
        $this->user = $user;
        $this->motivo = $motivo;
        $this->tipo = $tipo;

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

    public function toArray(object $notifiable): array
    {
        $message = $this->generateMessage();
    
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra,
            'tipo' => $this->tipo,
            'motivo' => $this->motivo,
            'message' => $message,
        ];
    }
    
    /**
     * Generate the message based on the tipo of alteration.
     */
    private function generateMessage(): string
    {
        switch ($this->tipo) {
            case 'secao':
                return 'O ' . $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra . ' pediu para ser trocado para a seção de ' . $this->motivo . '.';
            case 'status':
                return 'O ' . $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra . ' pediu para mudar seu status para ' . $this->motivo . '.';
            case 'nivel_acesso':
                return 'O ' . $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra . ' pediu para mudar seu nível de acesso para ' . $this->motivo . '.';
            default:
                return 'O ' . $this->user->pgrad_sigla . ' ' . $this->user->nome_guerra . ' fez uma solicitação de alteração.';
        }
    }
}
