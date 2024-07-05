<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PlanoChamadaRequest;
use Illuminate\Http\Request;
use App\Models\PlanoChamada;
use App\Models\User;
use App\Models\Pessoa;
use App\Models\Pgrad;
use App\Models\Secao;
use Illuminate\Http\Response as HttpResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PlanoChamadaController extends Controller
{
    protected $Pessoa = null;
    protected $Secao = null;
    protected $Pgrad = null;
    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userNivelAcessoID = 0;    

    public function __construct() 
    {
        $this->middleware('auth');
        $this->Pessoa = new Pessoa();
        $this->Secao = new Secao();
        $this->Pgrad = new Pgrad();
    }
    
    public function index($user_id = null) {

        // se não autenticado faz logout  // Auth::logout();
        if (! Auth::check()) return redirect('/home');

        // dd(Auth::user()->id);
        $user = User::with('pessoa')->find(Auth::user()->id);
        $pessoaAuth = Pessoa::with('pgrad')->find($user->id);
        $this->userID = $user->id;
        $this->userSecaoID = $user->pessoa->secao_id;
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;
        $pgrads = $this->Pgrad->all()->sortBy('id');

        // filtros aplicados segundo o níve de acesso
        if(in_array($this->userNivelAcessoID,[1,2,3])) {
            // Admin, Cmt e Enc Pes vem todos registros da OM
            $pessoas = $this->Pessoa->where('ativo','=','SIM')->orderBy('nome_guerra')->get();
            $secoes = $this->Secao->all()->sortBy('id');
            $arrFiltro['coluna'] = 'pessoas.id';
            $arrFiltro['operador'] = '>=';
            $arrFiltro['valor'] = '1';

        } elseif(in_array($this->userNivelAcessoID,[4,5])) {
            // Ch Seç e Sgtte vem todos registros da Seção
            $pessoas = $this->Pessoa::where('ativo','=','SIM')->where('secao_id','=',$this->userSecaoID)->orderBy('nome_guerra')->get();
            $secoes = $this->Secao::where('id','=',$this->userSecaoID)->orderBy('id')->get();
            $arrFiltro['coluna'] = 'pessoas.secao_id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userSecaoID;

        } else {
            // Usuário vê apenas seus registro pessoa_id', '=', $userID
            $pessoas = $this->Pessoa->where('ativo','=','SIM')->where('id','=',$this->userID)->orderBy('nome_guerra')->get();
            $secoes = $this->Secao::where('id','=',$this->userSecaoID)->orderBy('id')->get();
            $arrFiltro['coluna'] = 'pessoas.id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userID;
        }
        // dd($arrFiltro);

        if(request()->ajax()) {
            return DataTables::eloquent(PlanoChamada::select(['pessoas.*'])->with('pgrad')->with('secao')
                    ->orderBy('pgrad_id')->orderBy('nome_guerra')
                    ->where($arrFiltro['coluna'], $arrFiltro['operador'], $arrFiltro['valor'])
                )
                ->setRowId( function($param) { return $param->id; })
                ->addColumn('pgrad', function($param) { return $param->pgrad->sigla; })
                ->addColumn('secao', function($param) { return $param->secao->sigla; })
                ->addColumn('acoes', function ($param) {return $this->getActionColumn($param); })
                ->rawColumns(['acoes'])
                ->addIndexColumn()
                ->make(true);        
        }

        return view('negocio/PlanoChamadasDatatable',[
            'nivelAcesso' => $this->userNivelAcessoID, 
            'secoes' => $secoes, 
            'secao' => $this->userSecaoID, 
            'pessoas' => $pessoas, 
            'pessoaAuth' => $pessoaAuth, 
            'pgrads' => $pgrads, 
            'user' => $user,
            'user_id' => $user_id            
        ]);
    }

    protected function getActionColumn($row): string
    {
        $actions = '';
        $btnEditar  = '<button class="btnEditar  btn btn-primary btn-xs" data-toggle="tooltip" title="Editar este registro">Editar</button> ';
        $btnVer  = '<button class="btnEditar btn btn-info btn-xs" data-toggle="tooltip" title="Ver os detalhes deste registro">Ver</button> ';

        // btn Editar disponível para Admin, EncPes, Sgtte ou User dono
        if(in_array($this->userNivelAcessoID,[1,3,5,6])) {
            $actions .= $btnEditar;
        }

        // btn Ver disponível para Cmt e Ch Sec
        if(in_array($this->userNivelAcessoID,[2,4])) {

            // btn Editar disponível se o User for o dono da linha
            if($row->user_id == $this->userID) {
                $actions .= $btnEditar;
            } else {
                $actions .= $btnVer;
            }
        }

        return $actions;
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $PlanoChamada = PlanoChamada::where($where)->first();
        return Response()->json($PlanoChamada);
    }    

    public function store(PlanoChamadaRequest $request)
    {
        Log::info('Dados recebidos no request: ', $request->all());
        // verifica se o User tem permissão via Policy, retornar HTTP 422-Unprocesable Content que bloqueia o fechar do modal
        if($request->user()->cannot('PodeAtualizarPlanoChamada',PlanoChamada::class)) {
            //terminar o retorno JSON para bloquear o fechamento do Form e mostrar mensagem de erro
            $PlanoChamada = ['policyError' => 'Operação NÃO autorizada para seu Perfi de Acesso! (Policy)'];
            return Response()->json($PlanoChamada, HttpResponse::HTTP_UNPROCESSABLE_ENTITY); //422
        }

        try{
            $PlanoChamada = PlanoChamada::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'uf' => $request->uf,
                    'cep' => $request->cep,
                    'bairro' => $request->bairro,
                    'cidade' => $request->cidade,
                    'municipio_id' => $request->municipio_id,
                    'endereco' => $request->endereco,
                    'complemento' => $request->complemento,
                    'fone_celular' => $request->fone_celular,
                    'fone_emergencia' => $request->fone_emergencia,
                    'pessoa_emergencia' => $request->pessoa_emergencia,
                ]
            );  
            Log::info('Dados salvos com sucesso: ', $PlanoChamada->toArray());
            return Response()->json($PlanoChamada);
        } catch(\Exception $e) {
            Log::error('Erro ao salvar dados: ', ['error' => $e->getMessage()]);
            return Response()->json(['error' => 'Erro ao salvar dados'], 500);
        }

    }     

}
