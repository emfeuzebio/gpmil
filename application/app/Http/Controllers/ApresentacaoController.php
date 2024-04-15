<?php

namespace App\Http\Controllers;

// use App\DataTables\PessoaDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\ApresentacaoRequest;
use App\Models\Apresentacao;
use App\Models\Boletim;
use App\Models\Destino;
use App\Models\Pessoa;
use App\Models\Secao;
use DataTables;
use Yajra\DataTables\Contracts\DataTable;

class ApresentacaoController extends Controller
{
    
    protected $Pessoa = null;
    protected $Destino = null;
    protected $Boletim = null;
    protected $Secao = null;

    protected $nivelAcesso = 1;
    // protected $nivelAcesso = 2;
    // protected $nivelAcesso = 3;

    protected $secao = 13;

    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');

        //carrega a Circulo
        $this->Pessoa = new Pessoa();
        $this->Destino = new Destino();
        $this->Boletim = new Boletim();
        $this->Secao = new Secao();
    }
    
    public function index() {

        $nivelAcesso = 1;   //Administrador pode tudo
        $nivelAcesso = 2;   //Supervisor pode apenas ver tudo
        // $nivelAcesso = 3;   //Coordenador pode apenas ver seção
        // $nivelAcesso = 4;   //Gerente pode tudo na seção
        // $nivelAcesso = 5;   //Usuário pode tudo apenas para ele mesmo

<<<<<<< HEAD
            // return DataTable::eloquent(Apresentacao::select(['apresentacaos.*']))
            return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('pessoa','destino','boletim'))
                ->addColumn('pessoa', function($param) { return $param->pessoa?->nome_guerra; })
                ->addColumn('destino', function($param) { return $param->destino?->sigla; })
                ->addColumn('boletim', function($param) { return $param->boletim?->descricao; })
                // ->addColumn('pgrad', function($param) { return $param->pgrad->sigla; })
                // ->addColumn('qualificacao', function($param) { return $param->qualificacao->sigla; })
                // ->addColumn('action', function ($param) { return '<button data-id="' . $param->id . '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; })
                ->addIndexColumn()
                ->editColumn('dt_inicial', function ($param) { return date("d/m/Y", strtotime($param->dt_inicial)); })
                ->editColumn('dt_final', function ($param) { return date("d/m/Y", strtotime($param->dt_final)); })
                ->make(true);        
        }
=======
        $userID         = 1;    //1 - Super Usuário
        $userSecaoID    = 13;   //13 - ATI
>>>>>>> 05d5146958fc9eb9c1ef4e1a698e1380ae9ef9bf

        $boletins = $this->Boletim->all()->sortBy('id');
        $destinos = $this->Destino->all()->sortBy('descricao');
        $pessoas = $this->Pessoa->all()->sortBy('nome_guerra');

<<<<<<< HEAD
        return view('negocio/ApresentacaosDatatable',['boletins' => $boletins, 'destinos' => $destinos , 'pessoas' => $pessoas]);
=======
        $acoes = 'xxx';
        $btnEditar = '<button class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar este registro">Editar</button>';
    

        if($nivelAcesso == 1 || $nivelAcesso == 2) {
            $secoes = $this->Secao->all()->sortBy('descricao');
        } else {
            $secoes = $this->Secao::where('id','=',$userSecaoID)->orderBy('descricao')->get();
        }


        if(request()->ajax()) {


            // https://www.itsolutionstuff.com/post/laravel-one-to-one-eloquent-relationship-tutorialexample.html
            // https://github.com/Tucker-Eric/EloquentFilter
            // https://www.itsolutionstuff.com/post/laravel-datatables-filter-with-dropdown-exampleexample.html
            // https://laravel.com/docs/10.x/eloquent-collections

            if($nivelAcesso == 1 || $nivelAcesso == 2) {

                return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('destino')->with('pessoa')->with('boletim')->with('secao')
                        // ->where('apresentacaos.destino_id', '>=', '1')
                    )
                    ->addColumn('secao', function($param) { return $param->secao?->sigla; })            //se a secao.sigla estiver na própria apresentacao
                    ->addColumn('pessoa', function($param) { return $param->pessoa?->pgrad->sigla . ' ' . $param->pessoa?->nome_guerra; })
                    ->addColumn('destino', function($param) { return $param->destino?->sigla; })
                    ->addColumn('boletim', function($param) { return $param->boletim?->descricao; })
                    ->editColumn('dt_inicial', function ($param) { return date("d/m/Y", strtotime($param->dt_inicial)); })
                    ->editColumn('dt_final', function ($param) { return date("d/m/Y", strtotime($param->dt_final)); })
                    ->addColumn('acoes', function ($data) {return $this->getActionColumn($data); })
                    // ->addColumn('acoes', function ($param) { 
                    //             $btnEditar = '<button class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar este registro">Editar</button>';
                    //     return  $btnEditar; })
                    ->setRowId( function($param) { return $param->id; })
                    ->rawColumns(['acoes'])
                    ->addIndexColumn()
                    ->make(true);        
            }

            if($nivelAcesso == 3 || $nivelAcesso == 4) {

                return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('destino')->with('pessoa')->with('boletim')->with('secao')
                        ->where('apresentacaos.secao_id', '=', $userSecaoID)     //funciona se a secao_id estive na própria tabela apresentacoes
                    )
                    ->addColumn('secao', function($param) { return $param->secao?->sigla; })            //se a secao.sigla estiver na própria apresentacao
                    ->addColumn('pessoa', function($param) { return $param->pessoa?->pgrad->sigla . ' ' . $param->pessoa?->nome_guerra; })
                    ->addColumn('destino', function($param) { return $param->destino?->sigla; })
                    ->addColumn('boletim', function($param) { return $param->boletim?->descricao; })
                    ->editColumn('dt_inicial', function ($param) { return date("d/m/Y", strtotime($param->dt_inicial)); })
                    ->editColumn('dt_final', function ($param) { return date("d/m/Y", strtotime($param->dt_final)); })
                    ->addIndexColumn()
                    ->make(true);        

            }

            if($nivelAcesso == 5) {

                return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('destino')->with('pessoa')->with('boletim')->with('secao')
                        ->where('apresentacaos.pessoa_id', '=', $userID)     //funciona se a secao_id estive na própria tabela apresentacoes
                    )
                    ->addColumn('secao', function($param) { return $param->secao?->sigla; })            //se a secao.sigla estiver na própria apresentacao
                    ->addColumn('pessoa', function($param) { return $param->pessoa?->pgrad->sigla . ' ' . $param->pessoa?->nome_guerra; })
                    ->addColumn('destino', function($param) { return $param->destino?->sigla; })
                    ->addColumn('boletim', function($param) { return $param->boletim?->descricao; })
                    ->editColumn('dt_inicial', function ($param) { return date("d/m/Y", strtotime($param->dt_inicial)); })
                    ->editColumn('dt_final', function ($param) { return date("d/m/Y", strtotime($param->dt_final)); })
                    ->addIndexColumn()
                    ->make(true);  
            }


            // return DataTable::eloquent(Apresentacao::select(['apresentacaos.*']))
            // return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('pessoa','destino','boletim','DestinoFk'))
            // return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('destino')->with('pessoa')->with('boletim')->with('secao')
            //         ->where('apresentacaos.destino_id', '>=', '1')  //funciona filtran somente pela tabela principal 'apresentacoes'
            //         // ->where('apresentacaos.secao_id', '=', '3')     //funciona se a secao_id estive na própria tabela apresentacoes
            //         // ->orderBy('apresentacaos.publicado','desc')
            //         // ->orderBy('apresentacaos.dt_inicial','asc')
            //     )
            //     // ->filter(function ($query) { $query->where('apresentacaos.secao_id', '=', '3');} , true) //funciona se a secao_id estive na própria tabela apresentacoes
            //     // ->addColumn('secao', function($param) { return $param->pessoa?->secao->sigla; }) //se a secao.sigla estiver na pessoa
            //     ->addColumn('secao', function($param) { return $param->secao?->sigla; })            //se a secao.sigla estiver na própria apresentacao
            //     ->addColumn('pessoa', function($param) { return $param->pessoa?->pgrad->sigla . ' ' . $param->pessoa?->nome_guerra; })
            //     ->addColumn('destino', function($param) { return $param->destino?->sigla; })
            //     ->addColumn('boletim', function($param) { return $param->boletim?->descricao; })
            //     ->editColumn('dt_inicial', function ($param) { return date("d/m/Y", strtotime($param->dt_inicial)); })
            //     ->editColumn('dt_final', function ($param) { return date("d/m/Y", strtotime($param->dt_final)); })
            //     ->addIndexColumn()
            //     ->make(true);        
        }

        return view('negocio/ApresentacaosDatatable',['nivelAcesso' => $nivelAcesso, 'boletins' => $boletins, 'destinos' => $destinos, 'pessoas' => $pessoas, 'secoes' => $secoes]);
>>>>>>> 05d5146958fc9eb9c1ef4e1a698e1380ae9ef9bf
    }

    protected function getActionColumn($data): string
    {
        $actions = '';
        $btnEditar  = '<button class="btnEditar  btn btn-primary btn-xs" data-toggle="tooltip" title="Editar este registro">Editar</button> ';
        $btnExcluir = '<button class="btnExcluir btn btn-danger  btn-xs" data-toggle="tooltip" title="Excluir este registro">Excluir</button> ';
        $btnHomolg  = '<button class="btnHomologar  btn btn-info btn-xs" data-toggle="tooltip" title="Homologar este registro">Homlg</button> ';

        //implementar regras de controle de acesso aqui
        $actions    = $btnHomolg . $btnEditar . $btnExcluir;

        return $actions;
    }

    public function Select() {  

        // Forma de buscar os dados
        // 1 - Direto via Model: já sabe a tabela
        // $generos = GeneroModel::all()->sortBy('descricao');
        // $generos = GeneroModel::where('id_genero','<','5')->orderBy('descricao')->get();
        // $generos = GeneroModel::where('id_genero','<','10')->orderBy('descricao')->get();
        // // dd($generos);

        // // 2 - Via DB::table: usar a sintaxy própria do DB que abstrai os tipos de Bancos
        // $generos = DB::table('bib_genero')->select('*')->get();

        // // 3 - Via DB::select: livre para usar string SQL na mão
        // $sql = 'SELECT * from bib_genero WHERE id_genero < :param';
        // $generos = DB::select($sql, ['param'=> 8]);

        // $sql = 'SELECT * from bib_genero WHERE id_genero < ?';
        // $generos = DB::select($sql, [12]);

        // return view('generoList',['generos' => $generos]);        
 
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
                'observacao ' => $request->observacao,
                // 'prtsv' => $request->prtsv,
                'publicado' => $request->publicado,
            ]
        );  
        return Response()->json($Apresentacao);
    }     

    public function homologar(Request $request)
    {
        //usar outra forma de persistência para gravar apenas as duas colunas
        //senão será necessário gravar todos os dados após passar pelo Request
        $Apresentacao = Apresentacao::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'boletim_id' => $request->boletim_id,
                'publicado' => ( $request->boletim_id ? 'SIM' : 'NÃO' ),
<<<<<<< HEAD
                // 'publicado' => 'SIM',
=======
>>>>>>> 05d5146958fc9eb9c1ef4e1a698e1380ae9ef9bf
            ]
        );  
        return Response()->json($Apresentacao);
    }     

}
