<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FuncaoRequest;
use App\Models\Funcao;
use DataTables;
use DB;

class FuncaoController extends Controller
{
    
    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');
    }

    public function index() {

        if(request()->ajax()) {

            return DataTables::eloquent(Funcao::select(['funcaos.*']))
                ->filter(function ($query) { $query->where('id', '>', "1");}, true)        
                // ->addColumn('circulo', function($param) { return $param->circulo->sigla; })
                // ->addColumn('action', function ($param) { return '<button data-id="' . $param->id . '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; })
                ->addIndexColumn()
                // ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->make(true);        
        }
        return view('admin/FuncaosDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Funcao = Funcao::where($where)->first();
        return Response()->json($Funcao);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Funcao::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(FuncaoRequest $request)
    {

        $Funcao = Funcao::where(['id'=>$request->id]);
        //  dd($pgrad);
        //  die();

        // if(! $this->authorize('store', $pgrad)) {
        //     return response([], 403);
        //     // {"message":"Não autorizado.","errors":{"store":["Não autorizado."]}
        //     $message = ["message" => "Não autorizado!"];
        //     return Response()->json($message);
        // }        

        $Funcao = Funcao::updateOrCreate(
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
        return Response()->json($Funcao);
    }     

}
