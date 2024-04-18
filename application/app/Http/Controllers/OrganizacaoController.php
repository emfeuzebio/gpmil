<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrganizacaoRequest;
use App\Models\Organizacao;
use DataTables;
use DB;

class OrganizacaoController extends Controller
{
    
    public function __construct() {

        //somente Admin têm permissão
        // $this->authorize('is_admin');
    }

    public function index() {

        if(request()->ajax()) {

            return DataTables::eloquent(Organizacao::select(['organizacaos.*']))
                ->filter(function ($query) { $query->where('id', '>', "1");}, true)        
                // ->addColumn('circulo', function($param) { return $param->circulo->sigla; })
                // ->addColumn('action', function ($param) { return '<button data-id="' . $param->id . '" class="btnEditar btn btn-primary btn-sm" data-toggle="tooltip" title="Editar o registro atual">Editar</button>'; })
                ->addIndexColumn()
                // ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->make(true);        
        }
        return view('admin/OrganizacaosDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Organizacao = Organizacao::where($where)->first();
        return Response()->json($Organizacao);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Organizacao::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(OrganizacaoRequest $request)
    {

        $Organizacao = Organizacao::where(['id'=>$request->id]);
       
        $Organizacao = Organizacao::updateOrCreate(
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
        return Response()->json($Organizacao);
    }     

}
