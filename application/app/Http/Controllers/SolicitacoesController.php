<?php

namespace App\Http\Controllers;

use App\Models\Circulo;
use App\Models\NivelAcesso;
use App\Models\Pessoa;
use App\Models\Pgrad;
use App\Models\Secao;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SolicitacoesController extends Controller
{
    protected $Pgrad = null;
    protected $Pessoa = null;
    protected $Secao = null;

    protected $NivelAcesso = null;

    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userNivelAcessoID = 0;

    public function __construct() {

        $this->Pgrad = new Pgrad();
        $this->Secao = new Secao();
        $this->NivelAcesso = new NivelAcesso();
        $this->Pessoa = new Pessoa();
    }

    public function index()
    {
        $user = User::with('pessoa')->find(Auth::user()->id);

        // Obter todas as notificações não lidas
        // $notifications = $user->unreadNotifications;
        // dd($this->Pessoa->status);
        $solicitarSecaos = $this->Secao->where('ativo','=','SIM')->orderBy('descricao')->get();
        // $solicitarStatus = $this->Pessoa->status->where('ativo','=','SIM')->orderBy('descricao')->get();
        $solicitarNivelAcesso = $this->NivelAcesso->where('ativo','=','SIM')->orderBy('descricao')->get();

        return view('admin/Solicitacoes', ['solicitarSecaos' => $solicitarSecaos, 'solicitarNivelAcesso' => $solicitarNivelAcesso]);
    }
}
