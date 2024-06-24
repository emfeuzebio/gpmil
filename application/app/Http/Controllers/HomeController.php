<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\User;
use App\Models\Pgrad;
use App\Models\Secao;
use App\Models\Apresentacao;
use App\Models\Organizacao;
use App\Models\Ferias;
use App\Models\Destino;
use App\Models\Funcao;
use App\Models\NivelAcesso;
// use Illuminate\Contracts\Session\Session;
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
        $this->middleware('auth');
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

        // filtros aplicados segundo o níve de acesso
        if(in_array($this->userNivelAcessoID,[1,2,3])) {
            // Admin, Cmt e Enc Pes vem todos registros da OM
            $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->count();
            // $qtdPessoasFerias = Apresentacao::where('status', 'Férias')->count();
            // $qtdPessoasDestinos = Apresentacao::where('status', 'Destinos')->count();
            $qtdPessoasTotal = Pessoa::count();

        } elseif(in_array($this->userNivelAcessoID,[4,5])) {
            $secaoId = $this->userSecaoID; // Assuming there is a `secao_id` field in the user model to identify the section
            $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->where('secao_id', $secaoId)->count();
            // $qtdPessoasFerias = Apresentacao::where('status', 'Férias')->where('secao_id', $secaoId)->count();
            // $qtdPessoasDestinos = Apresentacao::where('status', 'Destinos')->where('secao_id', $secaoId)->count();
            $qtdPessoasTotal = Pessoa::where('secao_id', $secaoId)->count();

        } else {
            $pessoaId = $this->userID; // Assuming there is a `pessoa_id` field in the user model to identify the person
            $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->where('id', $pessoaId)->count();
            // $qtdPessoasFerias = Apresentacao::where('status', 'Férias')->where('pessoa_id', $pessoaId)->count();
            // $qtdPessoasDestinos = Apresentacao::where('status', 'Destinos')->where('pessoa_id', $pessoaId)->count();
            $qtdPessoasTotal = Pessoa::count(); // The user can see only their own status
        }

        $apresentacoes = Apresentacao::where('pessoa_id', $this->userID)->get();
        // dd($apresentacoes);

        // $secaos = $this->Secao->all()->sortBy('id');
        // dd($secaos);

        // $qtdPessoasAtivas = $this->Pessoa->all()->count();
        // $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->count();
        // $qtdPessoasFerias = Apresentacao::where('status', 'Férias')->count();
        // $qtdPessoasDestinos = Destino::where('status', 'Destinos')->count();
        // $qtdPessoasTotal = Pessoa::count();
        //dd($qtdPessoasAtivas);

        return view('home', [
            'qtdPessoasAtivas' => $qtdPessoasAtivas, 
            'user' => $user, 
            'pessoa' => $pessoa, 
            // 'qtdPessoasFerias' => $qtdPessoasFerias, 
            // 'qtdPessoasDestinos' => $qtdPessoasDestinos, 
            'qtdPessoasTotal' => $qtdPessoasTotal,
            'apresentacoes' => $apresentacoes,
            'organizacao' => $organizacao,
            'secaos'=> $secaos
        ]);
    }
}
