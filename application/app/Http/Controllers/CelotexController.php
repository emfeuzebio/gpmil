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
        return view('celotex');
    }

    public function getAniversariantes()
    {
        $startOfMonth = Carbon::now()->startOfWeek()->format('m-d');
        $endOfMonth = Carbon::now()->endOfWeek()->format('m-d');
    
        // Busca os aniversariantes do mês corrente com a sigla da graduação
        $aniversariantes = Pessoa::select('id', 'nome_guerra', 'pgrad_id', 'dt_nascimento', 'status')
            ->whereRaw("DATE_FORMAT(dt_nascimento, '%m-%d') BETWEEN ? AND ?", [$startOfMonth, $endOfMonth])
            ->with('pgrad')  // Carrega a relação com 'pgrad' para obter a sigla
            ->orderByRaw("DATE_FORMAT(dt_nascimento, '%m-%d')")
            ->get();
    
        return response()->json($aniversariantes);
    }
    
}
