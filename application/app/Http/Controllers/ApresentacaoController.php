<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ApresentacaoRequest;
use App\Models\Apresentacao;
use App\Models\Boletim;
use App\Models\Destino;
use App\Models\Pessoa;
use App\Models\Secao;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ApresentacaoController extends Controller
{
    // protected $User = null;
    protected $Pessoa = null;
    protected $Destino = null;
    protected $Boletim = null;
    protected $Secao = null;

    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userNivelAcessoID = 0;    

    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');
        // $can = $this->authorize('PodeInserirApresentacao',Apresentacao::class);
        // var_dump($can);
        // die();

        // carrega Entidades necessárias
        $this->Pessoa = new Pessoa();
        $this->Destino = new Destino();
        $this->Boletim = new Boletim();
        $this->Secao = new Secao();

    }
    
    public function index() {

        // Auth::logout();          // se não autenticado faz logout
        if (! Auth::check()) return redirect('/home');

        // dd(Auth::user()->id);
        // $this->User = User::with('pessoa')->find(Auth::user()->id);        
        $user = User::with('pessoa')->find(Auth::user()->id);
        $this->userID = $user->id;
        $this->userSecaoID = $user->pessoa->secao_id;
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;
        // echo "userNivelAcessoID = " . $user->pessoa->nivelacesso_id . "<br/>";
        // echo "userSecaoID > " . $user->pessoa->secao_id . "<br/>";
        // dd($user->pessoa);

        // $destinos = $this->Destino->all()->sortBy('descricao');
        $boletins = $this->Boletim->where('ativo','=','SIM')->orderBy('id')->get();
        $destinos = $this->Destino->where('ativo','=','SIM')->orderBy('descricao')->get();

        // filtros aplicados segundo o nível de acesso
        if(in_array($this->userNivelAcessoID,[1,2,3])) {
            $secoes = $this->Secao->where('ativo','=','SIM')->orderBy('descricao')->get();
            $pessoas = $this->Pessoa->where('ativo','=','SIM')->orderBy('nome_guerra')->get();

            // Admin, Cmt e Enc Pes vem todos registros da OM
            $arrFiltro['coluna'] = 'apresentacaos.id';
            $arrFiltro['operador'] = '>=';
            $arrFiltro['valor'] = '1';

        } elseif(in_array($this->userNivelAcessoID,[4,5])) {
            $secoes = $this->Secao->where('ativo','=','SIM')->where('id','=',$this->userSecaoID)->orderBy('descricao')->get();
            $pessoas = $this->Pessoa->where('ativo','=','SIM')->where('secao_id','=',$this->userSecaoID)->orderBy('nome_guerra')->get();

            // Ch Seç e Sgtte vem todos registros da Seção
            $arrFiltro['coluna'] = 'apresentacaos.secao_id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userSecaoID;
        } else {
            $secoes = $this->Secao->where('ativo','=','SIM')->where('id','=',$this->userSecaoID)->orderBy('descricao')->get();
            $pessoas = $this->Pessoa->where('ativo','=','SIM')->where('id','=',$this->userID)->orderBy('nome_guerra')->get();

            // Usuário vê apenas seus registro pessoa_id', '=', $userID
            $arrFiltro['coluna'] = 'apresentacaos.pessoa_id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userID;
        }

        if(request()->ajax()) {

            // https://www.itsolutionstuff.com/post/laravel-one-to-one-eloquent-relationship-tutorialexample.html
            // https://github.com/Tucker-Eric/EloquentFilter
            // https://www.itsolutionstuff.com/post/laravel-datatables-filter-with-dropdown-exampleexample.html
            // https://laravel.com/docs/10.x/eloquent-collections

            return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('destino')->with('pessoa')->with('boletim')->with('secao')
                    ->where($arrFiltro['coluna'], $arrFiltro['operador'], $arrFiltro['valor'])
                )
                ->setRowId( function($param) { return $param->id; })
                ->addColumn('secao', function($param) { return $param->secao?->sigla; })            //se a secao.sigla estiver na própria apresentacao
                ->addColumn('pessoa', function($param) { return $param->pessoa?->pgrad->sigla . ' ' . $param->pessoa?->nome_guerra; })
                ->addColumn('destino', function($param) { return $param->destino?->sigla; })
                ->addColumn('boletim', function($param) { return $param->boletim?->descricao; })
                ->editColumn('dt_inicial', function ($param) { return date("d/m/Y", strtotime($param->dt_inicial)); })
                ->editColumn('dt_final', function ($param) { return date("d/m/Y", strtotime($param->dt_final)); })
                ->addColumn('acoes', function ($param) {return $this->getActionColumn($param); })
                ->rawColumns(['acoes'])
                ->addIndexColumn()
                ->make(true);        

        }

        return view('negocio/ApresentacaosDatatable',['nivelAcesso' => $this->userNivelAcessoID, 'boletins' => $boletins, 'destinos' => $destinos, 'pessoas' => $pessoas, 'secoes' => $secoes]);
    }

    protected function getActionColumn($row): string
    {
        $actions = '';
        $btnEditar  = '<button class="btnEditar  btn btn-primary btn-xs" data-toggle="tooltip" title="Editar este registro">Editar</button> ';
        $btnExcluir = '<button class="btnExcluir btn btn-danger  btn-xs" data-toggle="tooltip" title="Excluir este registro">Excluir</button> ';
        $btnHomolg  = '<button class="btnHomologar  btn btn-info btn-xs" data-toggle="tooltip" title="Publicar este registro">Publi</button> ';

        // btn Homologar disponível apenas ao Admin ou Enc Pes
        if(in_array($this->userNivelAcessoID,[1,3,])) {
            $actions = $btnHomolg;
        }

        // btn Editar e Excluir disponível apenas para Admin, EncPes, Sgtte ou User
        if(in_array($this->userNivelAcessoID,[1,3,5,6])) {

            // btn Editar e Excluir disponível apenas se ainda não Homologado
            if($row->publicado == 'NÃO') {
                $actions .= $btnEditar . $btnExcluir;
            }
        }
        return $actions;
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Apresentacao = Apresentacao::where($where)->first();
        return Response()->json($Apresentacao);
    }    

    public function destroy(Request $request)
    {        
        $Apresentacao = Apresentacao::where(['id'=>$request->id])->delete();
        return Response()->json($Apresentacao);
    }   

    public function store(ApresentacaoRequest $request)
    {

        // verifica se o User tem permissão via Policy
        // necessário retornar HTTP 422-Unprocesable Content que bloqueia fechar o modal
        if($request->user()->cannot('PodeInserirApresentacao',Apresentacao::class)) {
            //terminar o retorno JSON para bloquear o fechamento do Form e mostrar mensagem de erro
            $Apresentacao = ['message' => 'Operação NÃO autorizada!','errors' => ['form'=>'Form: Operação NÃO autorizada']];
            return Response()->json($Apresentacao);
        }

        //busca a Pessoa para obter a Seção da mesma
        $pessoa = $this->Pessoa->find($request->pessoa_id);

        $Apresentacao = Apresentacao::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'pessoa_id' => $request->pessoa_id,
                'destino_id' => $request->destino_id,
                'boletim_id' => $request->boletim_id,
                // 'dt_apres' => $request->dt_apres,
                'dt_inicial' => $request->dt_inicial,
                'dt_final' => $request->dt_final,
                'local_destino' => $request->local_destino,
                'celular' => $request->celular,
                'observacao' => $request->observacao,
                // 'prtsv' => $request->prtsv,
                'publicado' => $request->publicado,
                'secao_id' => $pessoa->secao_id,    //pega da pessoa
            ]
        );  
        return Response()->json($Apresentacao);
    }     

    public function homologar(Request $request)
    {
        $Apresentacao = Apresentacao::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'boletim_id' => $request->boletim_id,
                'publicado' => ( $request->boletim_id ? 'SIM' : 'NÃO' ),
            ]
        );  
        return Response()->json($Apresentacao);
    }     

}