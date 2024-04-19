<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoChamadaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PlanoChamada;
use App\Models\User;
use App\Models\Pgrad;
use App\Models\Pessoa;
use App\Models\Secao;
use DataTables;


class PlanoChamadaController extends Controller
{

    // protected $User = null;
    protected $Pessoa = null;

    // protected $Municipio = null;
    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userNivelAcessoID = 0;    

    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');
        // $can = $this->authorize('PodeInserirPlanoChamada',PlanoChamada::class);
        // var_dump($can);
        // die();

        // carrega Entidades necessárias
        $this->Pessoa = new Pessoa();
    }
    
    public function index() {

        // dd(Auth::user()->id);
        // $this->User = User::with('pessoa')->find(Auth::user()->id);        
        $user = User::with('pessoa')->find(Auth::user()->id);
        $this->userID = $user->id;
        $this->userSecaoID = $user->pessoa->secao_id;
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;
        // echo "userNivelAcessoID = " . $user->pessoa->nivelacesso_id . "<br/>";
        // echo "userSecaoID > " . $user->pessoa->secao_id . "<br/>";
        // die();
        // dd($user->pessoa);

        // $municipios = $this->Pessoa->where('ativo','=','SIM')->orderBy('nome_guerra')->get();

        // filtros aplicados segundo o níve de acesso
        if(in_array($this->userNivelAcessoID,[1,2,3])) {
            // Admin, Cmt e Enc Pes vem todos registros da OM
            $arrFiltro['coluna'] = 'pessoas.id';
            $arrFiltro['operador'] = '>=';
            $arrFiltro['valor'] = '1';

        } elseif(in_array($this->userNivelAcessoID,[4,5])) {
            // Ch Seç e Sgtte vem todos registros da Seção
            $arrFiltro['coluna'] = 'pessoas.secao_id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userSecaoID;
        } else {
            // Usuário vê apenas seus registro pessoa_id', '=', $userID
            $arrFiltro['coluna'] = 'pessoas.pessoa_id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userID;
        }
        // dd($arrFiltro);

        if(request()->ajax()) {

            return DataTables::eloquent(PlanoChamada::select(['pessoas.*'])->with('pgrad')->with('secao')
                    // ->where($arrFiltro['coluna'], $arrFiltro['operador'], $arrFiltro['valor'])
                )
                ->addColumn('pgrad', function($param) { return $param->pgrad->sigla; })
                ->addColumn('secao', function($param) { return $param->secao->sigla; })
                ->addColumn('acoes', function ($param) {return $this->getActionColumn($param); })
                ->rawColumns(['acoes'])
                ->addIndexColumn()
                ->setRowId( function($param) { return $param->id; })
                ->make(true);        

        }

        return view('negocio/PlanoChamadasDatatable',['nivelAcesso' => $this->userNivelAcessoID]);
    }

    protected function getActionColumn($row): string
    {
        $actions = '';
        $btnEditar  = '<button class="btnEditar  btn btn-primary btn-xs" data-toggle="tooltip" title="Editar este registro">Editar</button> ';

        // btn Editar disponível apenas para Admin, EncPes, Sgtte ou User dono
        if(in_array($this->userNivelAcessoID,[1,3,5,6])) {
            $actions .= $btnEditar;
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
        // verifica se o User tem permissão via Policy
        // $can = $request->user()->can('PodeInserirPlanoChamada',PlanoChamada::class);
        // var_dump($can);

        // verifica se o User tem permissão via Policy
        // necessário retornar HTTP 422-Unprocesable Content que bloqueia fechar o modal
        if($request->user()->cannot('PodeAtualizarPlanoChamada',PlanoChamada::class)) {
            //terminar o retorno JSON para bloquear o fechamento do Form e mostrar mensagem de erro
            $PlanoChamada = ['message' => 'Operação NÃO autorizada!','errors' => ['form'=>'Form: Operação NÃO autorizada']];
            return Response()->json($PlanoChamada);
        }

        $PlanoChamada = PlanoChamada::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'uf' => $request->uf,
                'cep' => $request->cep,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'endereco' => $request->endereco,
                'complemento' => $request->complemento,
                'fone_celular' => $request->fone_celular,
                'fone_emergencia' => $request->fone_emergencia,
                'pessoa_emergencia' => $request->pessoa_emergencia,
            ]
        );  
        return Response()->json($PlanoChamada);
    }     

}
