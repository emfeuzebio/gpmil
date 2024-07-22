<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\User;
use App\Models\Pgrad;
use App\Models\Secao;
use App\Models\Apresentacao;
use App\Models\Organizacao;
use App\Models\Funcao;
use App\Models\NivelAcesso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    protected $Pessoa = null;
    protected $Pgrad = null;
    protected $Secao = null;
    protected $Funcao = null;
    protected $NivelAcesso = null;

    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userFuncaoID = 0;
    protected $userNivelAcessoID = 0;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->Pessoa = new Pessoa();
        $this->Pgrad = new Pgrad();
        $this->Secao = new Secao();
        $this->Funcao = new Funcao();
        $this->NivelAcesso = new NivelAcesso();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::with('pessoa')->find(Auth::user()->id);
        $pessoa = Pessoa::with('pgrad')->find($user->id);
        $secaos = Secao::find($user->pessoa->secao_id);
        $organizacao = Organizacao::find($user->pessoa->organizacao_id);
    
        $this->userID = $user->id;
        $this->userSecaoID = $user->pessoa->secao_id;
        $this->userFuncaoID = $user->pessoa->funcao_id;
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;
    
        $now = Carbon::now();
    
        $qtdPessoasFerias = 0;
        $qtdPessoasDispensa = 0;
        $qtdPessoasAfasSede = 0;
        $qtdPessoasTotal = Pessoa::where('ativo', 'SIM')->count();
    
        if (in_array($this->userNivelAcessoID, [1, 2, 3])) {
            // Admin, Cmt e Enc Pes veem todos os registros da OM
            $qtdPessoasFerias = Apresentacao::whereIn('destino_id', [2, 3, 4])
                ->whereNull('apresentacao_id')
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasDispensa = Apresentacao::whereIn('destino_id', [5, 6])
            ->whereNull('apresentacao_id')
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasAfasSede = Apresentacao::where('destino_id', 1)
                ->whereNull('apresentacao_id')
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasProntas = $qtdPessoasTotal - ($qtdPessoasFerias + $qtdPessoasDispensa + $qtdPessoasAfasSede);
    
        } elseif (in_array($this->userNivelAcessoID, [4, 5])) {
            // Filtros para usuários com nível de acesso 4 e 5
            $secaoId = $this->userSecaoID;
    
            $qtdPessoasFerias = Apresentacao::whereIn('destino_id', [2, 3, 4])
                ->whereNull('apresentacao_id')
                ->whereHas('pessoa', function($query) use ($secaoId) {
                    $query->where('secao_id', $secaoId);
                })
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasDispensa = Apresentacao::whereIn('destino_id', [5, 6])
                ->whereNull('apresentacao_id')
                ->whereHas('pessoa', function($query) use ($secaoId) {
                    $query->where('secao_id', $secaoId);
                })
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasAfasSede = Apresentacao::where('destino_id', 1)
                ->whereNull('apresentacao_id')
                ->whereHas('pessoa', function($query) use ($secaoId) {
                    $query->where('secao_id', $secaoId);
                })
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasTotal = Pessoa::where('secao_id', $secaoId)->where('ativo', 'SIM')->count();
    
            $qtdPessoasProntas = $qtdPessoasTotal - ($qtdPessoasFerias + $qtdPessoasDispensa + $qtdPessoasAfasSede);
    
        } else {
            // Filtros para usuários com nível de acesso inferior
            $pessoaId = $this->userID;
    
            $qtdPessoasFerias = Apresentacao::whereIn('destino_id', [2, 3, 4])
                ->whereNull('apresentacao_id')
                ->where('pessoa_id', $pessoaId)
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasDispensa = Apresentacao::whereIn('destino_id', [5, 6])
                ->whereNull('apresentacao_id')
                ->where('pessoa_id', $pessoaId)
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasAfasSede = Apresentacao::where('destino_id', 1)
                ->whereNull('apresentacao_id')
                ->where('pessoa_id', $pessoaId)
                ->where('dt_inicial', '<=', $now)
                ->where('dt_final', '>=', $now)->count();
    
            $qtdPessoasTotal = Pessoa::where('ativo', 'SIM')->where('id', $pessoaId)->count();
    
            $qtdPessoasProntas = $qtdPessoasTotal - ($qtdPessoasFerias + $qtdPessoasDispensa + $qtdPessoasAfasSede);
        }
    
        $apresentacoes = Apresentacao::where('pessoa_id', $this->userID)->get();
    
        $startOfWeek = $now->startOfWeek(Carbon::SUNDAY)->format('m-d');
        $endOfWeek = $now->endOfWeek(Carbon::SATURDAY)->format('m-d');
    
        $aniversariantes = Pessoa::whereRaw("
            DATE_FORMAT(dt_nascimento, '%m-%d') >= ? 
            AND DATE_FORMAT(dt_nascimento, '%m-%d') <= ?
        ", [$startOfWeek, $endOfWeek])
            ->get()
            ->sortBy(function($aniversariantes) {
                return Carbon::createFromFormat('Y-m-d', $aniversariantes->dt_nascimento)->format('m-d');
            });
    
        return view('home', [
            'qtdPessoasProntas' => $qtdPessoasProntas, 
            'user' => $user, 
            'pessoa' => $pessoa, 
            'qtdPessoasFerias' => $qtdPessoasFerias, 
            'qtdPessoasDispensa' => $qtdPessoasDispensa, 
            'qtdPessoasAfasSede' => $qtdPessoasAfasSede, 
            'qtdPessoasTotal' => $qtdPessoasTotal,
            'apresentacoes' => $apresentacoes,
            'organizacao' => $organizacao,
            'secaos' => $secaos,
            'aniversariantes' => $aniversariantes
        ]);
    }
    
}
