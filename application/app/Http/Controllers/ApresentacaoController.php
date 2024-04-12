<?php

namespace App\Http\Controllers;

// use App\DataTables\PessoaDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\ApresentacaoRequest;
use App\Models\Apresentacao;
use App\Models\Boletim;
use App\Models\Destino;
use App\Models\Pessoa;
use DataTables;
use Yajra\DataTables\Contracts\DataTable;

class ApresentacaoController extends Controller
{
    
    protected $Pessoa = null;
    protected $Destino = null;
    protected $Boletim = null;

    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');

        //carrega a Circulo
        $this->Pessoa = new Pessoa();
        $this->Destino = new Destino();
        $this->Boletim = new Boletim();
    }
    
    public function index() {

        if(request()->ajax()) {

            // return DataTable::eloquent(Apresentacao::select(['apresentacaos.*']))
            return DataTables::eloquent(Apresentacao::select(['apresentacaos.*'])->with('pessoa','destino','boletim'))
                ->addColumn('pessoa', function($param) { return $param->pessoa?->pgrad->sigla . ' ' . $param->pessoa?->nome_guerra; })
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

        $boletins = $this->Boletim->all()->sortBy('id');
        $destinos = $this->Destino->all()->sortBy('descricao');
        $pessoas = $this->Pessoa->all()->sortBy('nome_guerra');

        return view('negocio/ApresentacaosDatatable',['boletins' => $boletins, 'destinos' => $destinos, 'pessoas' => $pessoas]);
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
            ]
        );  
        return Response()->json($Apresentacao);
    }     

}
