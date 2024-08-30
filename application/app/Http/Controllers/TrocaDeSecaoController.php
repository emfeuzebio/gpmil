<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pessoa;
use App\Notifications\TrocaDeSecaoNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrocaDeSecaoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obter todas as notificações não lidas
        $notifications = $user->unreadNotifications;

        return view('notificacoes/solicitar-troca', ['notifications' => $notifications]);
    }

    public function solicitar(Request $request)
    {
        // Validação do formulário
        $request->validate([
            'solicitacao' => 'required|string|max:255',
            'tipo' => 'required|string',
        ]);
    
        // Obter o usuário autenticado
        $user = Auth::user();
    
        // IDs dos níveis de acesso para administrador e encarregado de pessoal
        $accessLevels = [1, 3];
    
        // Encontrar todos os usuários com nivelacesso_id = 1 ou = 3
        $responsaveis = Pessoa::whereIn('nivelacesso_id', $accessLevels)->get();
    
        if ($responsaveis->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum encarregado de pessoal ou administrador encontrado.');
        }
    
        // Enviar notificação para cada responsável
        foreach ($responsaveis as $responsavel) {
            $pessoa = User::find($responsavel->id);
            if ($pessoa) {
                $pessoa->notify(new TrocaDeSecaoNotification($user, $request->input('solicitacao'), $request->input('tipo')));
            }
        }
    
        // Redirecionar com mensagem de sucesso
        return redirect()->back()->with('success', 'Solicitação enviada com sucesso.');
    }
    

    public function update()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;
        $dropdownHtml = '';
        // dd($notifications);
        foreach ($notifications as $key => $not) {
            $text = Str::limit($not->data['message'], 15);
            $icon = "<i class='mr-2 fas fa-user'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                   {$not->created_at->diffForHumans()}
                 </span>";

            $dropdownHtml .= "<a href='" . url('pessoas/' . $not->data['user_id']) . "' class='dropdown-item'>
                                {$icon}{$text}{$time}
                            </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Retorna as notificações em formato JSON

        return [
            'label' => count($notifications),
            'label_color' => 'danger',
            'dropdown' => $dropdownHtml,
        ];

    }

    public function markAsRead($id)
    {
        $user = auth()->user();
        $notification = $user->unreadNotifications->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

}
