<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DestinoRequest;
use App\Models\Destino;
use DataTables;
use DB;

class DestinoController extends Controller
{
    
    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');
    }

    public function index() {

        if(request()->ajax()) {
            // return 
            //     datatables()->of(Pgrad::select('*'))
            return DataTables::eloquent(Destino::select(['destinos.*']))
                // ->addColumn('circulo', function($param) { return $param->circulo->sigla; })
                // ->addColumn('action', function ($param) { return '<button data-id="' . $param->id . '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; })
                ->addIndexColumn()
                // ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->make(true);        
        }
        return view('admin/DestinosDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Destino = Destino::where($where)->first();
        return Response()->json($Destino);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Destino::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(DestinoRequest $request)
    {

        $destino = Destino::where(['id'=>$request->id]);
        //  dd($pgrad);
        //  die();

        // if(! $this->authorize('store', $pgrad)) {
        //     return response([], 403);
        //     // {"message":"Não autorizado.","errors":{"store":["Não autorizado."]}
        //     $message = ["message" => "Não autorizado!"];
        //     return Response()->json($message);
        // }        

        $Destino = Destino::updateOrCreate(
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
        return Response()->json($Destino);
    }     

}
