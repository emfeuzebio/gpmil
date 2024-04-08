<?php

namespace App\Http\Controllers;

use App\DataTables\PgradsDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\PgradRequest;   //validação de servidor
use App\Models\Circulo;
use App\Models\Pgrad;
use Session;
use DataTables;
use DB;

class PgradController extends Controller
{
    
    // private Organizacao = $X;
    protected $Circulo = null;

    public function __construct() {
        //carrega a Circulo
        $this->Circulo = new Circulo();
    }

    public function indexRender(PgradsDataTable $dataTable)
    {
        return $dataTable->render('users.pgrads');
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
            // return 
            //     datatables()->of(Pgrad::select('*'))
            return DataTables::eloquent(Pgrad::select(['pgrads.*'])->with('circulo'))
                ->addColumn('circulo', function($param) { return $param->circulo->sigla; })
                ->addIndexColumn()
                ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->make(true);        
        }

        //busca lista de Circulos para usar nos combos da view
        // $circulos = $this->Circulo->all()->sortBy('descricao');
        $circulos = $this->Circulo->all()->sortBy('id');

        return view('PgradsDatatable',['circulos'=> $circulos]);
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

        return view('PgradsDatatable',['generos' => $generos]);
 
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Pgrad = Pgrad::where($where)->first();
        return Response()->json($Pgrad);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Pgrad::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(PgradRequest $request)
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

        $Pgrad = Pgrad::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'circulo_id' => $request->circulo_id,
                'sigla' => $request->sigla,
                'descricao' => $request->descricao,
                'ativo' => $request->ativo,
            ]
        );  
        return Response()->json($Pgrad);
    }     

}
