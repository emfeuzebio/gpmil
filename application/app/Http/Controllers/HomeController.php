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
use Carbon\Carbon;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

        $hoje = date("d-m-Y");

        $dt_inicial = Apresentacao::select('dt_inicial')->first();
        $dt_final = Apresentacao::select('dt_final')->first();

        $qtdPessoasFerias = 0;
        $qtdPessoasDispensa = 0;
        $qtdPessoasAfasSede = 0;
        $qtdPessoasAtivas = 0;
        $qtdPessoasTotal = 0;

        if ($dt_inicial && $dt_final) {
            $dt_inicial = Carbon::parse($dt_inicial->dt_inicial);
            $dt_final = Carbon::parse($dt_final->dt_final);
    
            if ($dt_inicial->lte($hoje) && $dt_final->gte($hoje)) {
                if (in_array($this->userNivelAcessoID, [1, 2, 3])) {
                    // Admin, Cmt e Enc Pes veem todos os registros da OM
                    $qtdPessoasFerias = Apresentacao::whereIn('destino_id', [2, 3, 4])->count();
                    $qtdPessoasDispensa = Apresentacao::whereIn('destino_id', [5, 6])->count();
                    $qtdPessoasAfasSede = Apresentacao::where('destino_id', 1)->count();
                    $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->count();
                    $qtdPessoasTotal = Pessoa::where('ativo', 'SIM')->count();

                    // Subtrair as quantidades
                    $qtdPessoasAtivas -= ($qtdPessoasFerias + $qtdPessoasDispensa + $qtdPessoasAfasSede);
                } elseif (in_array($this->userNivelAcessoID, [4, 5])) {
                    // Filtros para usuários com nível de acesso 4 e 5
                    $secaoId = $this->userSecaoID;
                    $qtdPessoasFerias = Apresentacao::whereIn('destino_id', [2, 3, 4])
                        ->whereHas('pessoa', function($query) use ($secaoId) {
                            $query->where('secao_id', $secaoId);
                        })->count();
                    $qtdPessoasDispensa = Apresentacao::whereIn('destino_id', [5, 6])
                        ->whereHas('pessoa', function($query) use ($secaoId) {
                            $query->where('secao_id', $secaoId);
                        })->count();
                    $qtdPessoasAfasSede = Apresentacao::where('destino_id', 1)
                        ->whereHas('pessoa', function($query) use ($secaoId) {
                            $query->where('secao_id', $secaoId);
                        })->count();
                    $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->where('secao_id', $secaoId)->count();
                    $qtdPessoasTotal = Pessoa::where('secao_id', $secaoId)->where('ativo', 'SIM')->count();

                    // Subtrair as quantidades
                    $qtdPessoasAtivas -= ($qtdPessoasFerias + $qtdPessoasDispensa + $qtdPessoasAfasSede);
                } else {
                    // Filtros para usuários com nível de acesso inferior
                    $pessoaId = $this->userID;
                    $qtdPessoasFerias = Apresentacao::whereIn('destino_id', [2, 3, 4])
                        ->where('pessoa_id', $pessoaId)->count();
                    $qtdPessoasDispensa = Apresentacao::whereIn('destino_id', [5, 6])
                        ->where('pessoa_id', $pessoaId)->count();
                    $qtdPessoasAfasSede = Apresentacao::where('destino_id_id', 1)
                        ->where('pessoa_id', $pessoaId)->count();
                    $qtdPessoasAtivas = Pessoa::where('ativo', 'SIM')->where('id', $pessoaId)->count();
                    $qtdPessoasTotal = Pessoa::where('ativo', 'SIM')->count(); // The user can see only their own status

                    // Subtrair as quantidades
                    $qtdPessoasAtivas -= ($qtdPessoasFerias + $qtdPessoasDispensa + $qtdPessoasAfasSede);
                }
            }
        }

        $apresentacoes = Apresentacao::where('pessoa_id', $this->userID)->get();

        // Data atual
        $now = Carbon::now();

        // Primeira e última data da semana atual
        $startOfWeek = $now->startOfWeek(Carbon::SUNDAY)->format('m-d');
        $endOfWeek = $now->endOfWeek(Carbon::SATURDAY)->format('m-d');

        // Buscar pessoas com aniversário na semana atual usando Eloquent
        $aniversariantes = Pessoa::whereRaw("
            DATE_FORMAT(dt_nascimento, '%m-%d') >= ? 
            AND DATE_FORMAT(dt_nascimento, '%m-%d') <= ?
        ", [$startOfWeek, $endOfWeek])
                                ->get()
                                ->sortBy(function($aniversariantes) {
                                    return Carbon::createFromFormat('Y-m-d', $aniversariantes->dt_nascimento)->format('m-d');
                                });

        return view('home', [
            'qtdPessoasAtivas' => $qtdPessoasAtivas, 
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
