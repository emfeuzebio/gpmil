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

        //somente Admin têm permissão
        // $this->authorize('is_admin');

        //carrega a Circulo
        $this->Circulo = new Circulo();
    }

    public function indexRender(PgradsDataTable $dataTable)
    {
        // return $dataTable->render('users.pgrads');
    }    
    
    public function index() {

        if(request()->ajax()) {
            return DataTables::eloquent(Pgrad::select(['pgrads.*'])->with('circulo'))
                ->setRowId( function($param) { return $param->id; })
                ->addColumn('circulo', function($param) { return $param->circulo->sigla; })
                ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->addIndexColumn()
                ->make(true);        
        }

        //busca lista de Circulos para usar nos combos da view
        $circulos = $this->Circulo->all()->sortBy('id');

        return view('admin/PgradsDatatable',['circulos'=> $circulos]);
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
