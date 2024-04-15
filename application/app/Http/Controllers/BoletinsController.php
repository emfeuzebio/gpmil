<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BoletinsRequest;
use App\Models\Boletins;
use DataTables;
use DB;

class BoletinsController extends Controller
{
    
    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');
    }

    public function index() {

        if(request()->ajax()) {
            // return 
            //     datatables()->of(Pgrad::select('*'))
            return DataTables::eloquent(Boletins::select(['boletins.*']))
                // ->addColumn('circulo', function($param) { return $param->circulo->descricao; })
                // ->addColumn('action', function ($param) { return '<button data-id="' . $param->id . '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; })
                ->addIndexColumn()
                ->editColumn('data', function ($param) { return date("d/m/Y", strtotime($param->data)); })
                ->make(true);        
        }
        return view('admin/BoletinsDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Boletins = Boletins::where($where)->first();
        return Response()->json($Boletins);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Boletins::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(BoletinsRequest $request)
    {

        $boletins = Boletins::where(['id'=>$request->id]);
        //  dd($pgrad);
        //  die();

        // if(! $this->authorize('store', $pgrad)) {
        //     return response([], 403);
        //     // {"message":"Não autorizado.","errors":{"store":["Não autorizado."]}
        //     $message = ["message" => "Não autorizado!"];
        //     return Response()->json($message);
        // }        

        $Boletins = Boletins::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'id' => $request->circulo_id,
                'descricao' => $request->descricao,
                'data' => $request->data,
                'ativo' => $request->ativo,
            ]
        );  
        return Response()->json($Boletins);
    }     

}
