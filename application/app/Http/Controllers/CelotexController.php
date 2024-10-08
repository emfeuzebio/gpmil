<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use App\Models\NivelAcesso;
use App\Models\Organizacao;
use App\Models\Pessoa;
use App\Models\Pgrad;
use App\Models\Secao;
use App\Models\User;
use App\Models\Celotex;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CelotexController extends Controller
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

    public function index()
    {
        // $user = User::with('pessoa')->find(Auth::user()->id);
        // $pessoa = Pessoa::with('pgrad')->find($user->id);
        // $secaos = Secao::find($user->pessoa->secao_id);
        // $organizacao = Organizacao::find($user->pessoa->organizacao_id);
    
        // $this->userID = $user->id;
        // $this->userSecaoID = $user->pessoa->secao_id;
        // $this->userFuncaoID = $user->pessoa->funcao_id;
        // $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;
    
        // $now = Carbon::now();

        $startOfMonth = Carbon::now()->startOfMonth()->format('m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('m-d');
        
        // Busca os aniversariantes do mês corrente
        $aniversariantes = Pessoa::whereRaw("
            DATE_FORMAT(dt_nascimento, '%m-%d') >= ? 
            AND DATE_FORMAT(dt_nascimento, '%m-%d') <= ?
        ", [$startOfMonth, $endOfMonth])
            ->get()
            ->sortBy(function($aniversariante) {
                return Carbon::createFromFormat('Y-m-d', $aniversariante->dt_nascimento)->format('m-d');
            });

        // dd($aniversariantes);

        return view('celotex', [
            'aniversariantes' => $aniversariantes
        ]);
    }
}
