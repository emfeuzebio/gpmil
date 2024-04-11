<?php

namespace App\Http\Controllers;

use App\DataTables\PessoaDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaRequest;   //validação de servidor
use App\Models\Circulo;
use App\Models\Pgrad;
use App\Models\Pessoa;
use App\Models\Qualificacao;
use Session;
use DataTables;
use DB;

class PessoaController extends Controller
{
    
    // private Organizacao = $X;
    protected $Circulo = null;
    protected $Pgrad = null;
    protected $Qualificacao = null;

    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');

        //carrega a Circulo
        $this->Circulo = new Circulo();
        $this->Pgrad = new Pgrad();
        $this->Qualificacao = new Qualificacao();
    }

    public function indexRender(PessoaDataTable $dataTable)
    {
        // return $dataTable->render('users.pessoa');
    }    
    
    public function index() {


        // if(request()->ajax()) {
            
            // $data = request()->all();
            // print_r($data);
            //echo request()->get('zFiltro_0'); //captura o parâmetro vindo por GET

            // $filter = '';
            // if(empty(request()->get('zFiltro_0'))) {
            //     return DataTables::eloquent(Pgrad::select(['bib_genero.*'])->with('OrganizacaoFk'))
            //     ->addColumn('organizacao', function($param) { return $param->OrganizacaoFk->sigla; })           //JOIN
            //     ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })  //Formata
            //     // ->addIndexColumn()       //cria o DT_RowIndex no JSON do DataTables, usar se necessário
            //     ->make(true);
                
            // } else {

            //     //->with('') - faz o JOIN com tabela especificada no Model através BelongTo->('EditoraFk'): GeneroFk
            //     //neste exemplo temos 3 relacionamentos estabelecidos
            //     return DataTables::eloquent(Pgrad::select(['bib_genero.*'])->with('OrganizacaoFk')
            //         ->where('organizacao_id', request()->get('zFiltro_0')))                                 //filtro WHERE
            //         ->addColumn('organizacao', function($param) { return $param->OrganizacaoFk->sigla; })   //trás dados da tabela JOIN
            //         ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })  //Formata
            //         ->make(true);
            // }
        // }        

        if(request()->ajax()) {

            return DataTables::eloquent(Pessoa::select(['pessoas.*'])->with('pgrad', 'qualificacao'))
                ->addColumn('pgrad', function($param) { return $param->pgrad->sigla; })
                ->addColumn('qualificacao', function($param) { return $param->qualificacao->sigla; })
                ->addColumn('action', function ($param) { return '<button data-id="' . $param->id . '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; })
                ->addIndexColumn()
                ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->make(true);        
        }


        $pgrads = $this->Pgrad->all()->sortBy('id');
        $qualificacaos = $this->Qualificacao->all()->sortBy('id');

        return view('admin/PessoasDatatable', ['pgrads'=> $pgrads], ['qualificacaos'=> $qualificacaos]);
    }


    public function Select() {  

        // Forma de buscar os dados
        // 1 - Direto via Model: já sabe a tabela
        $generos = Pgrad::all()->sortBy('descricao');

        // $generos = Pgrad::where('id_genero','<','5')->orderBy('descricao')->get();
        // $generos = Pgrad::where('id_genero','<','10')->orderBy('descricao')->get();
        // dd($generos);

        // 2 - Via DB::table: usar a sintaxy própria do DB que abstrai os tipos de Bancos
        // $generos = DB::table('bib_genero')->select('*')->get();

        // 3 - Via DB::select: livre para usar string SQL na mão
        // $sql = 'SELECT * from bib_genero WHERE id_genero < :param';
        // $generos = DB::select($sql, ['param'=> 8]);

        // $sql = 'SELECT * from bib_genero WHERE id_genero < ?';
        // $generos = DB::select($sql, [12]);

        return view('PessoaDatatable',['generos' => $generos]);
 
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Pessoa = Pessoa::where($where)->first();
        return Response()->json($Pessoa);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Pessoa::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(PessoaRequest $request)
    {

        $pgrad = Pgrad::where(['id'=>$request->id]);
        //  dd($pgrad);
        //  die();

        // if(! $this->authorize('store', $pgrad)) {
        //     return response([], 403);
        //     // {"message":"Não autorizado.","errors":{"store":["Não autorizado."]}
        //     $message = ["message" => "Não autorizado!"];
        //     return Response()->json($message);
        // }        

        $Pessoa = Pessoa::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'pgrad_id' => $request->pgrad_id,
                'nome_completo' => $request->nome_completo,
                'nome_guerra' => $request->nome_guerra,
                'ativo' => $request->ativo,
            ]
        );  
        return Response()->json($Pessoa);
    }     

}
