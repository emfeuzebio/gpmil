<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Requests\SecaoRequest;
use App\Models\Secao;


class SecaoController extends Controller
{
    
    public function __construct() {
        // WEB controla para que todo controler somente será acessível se usuário logado
    }


    public function index() {

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Secao())) {
            abort(403, 'Usuário não autorizado!');
        }      

        if(request()->ajax()) {

            return DataTables::eloquent(Secao::select(['secaos.*']))
                ->filter(function ($query) { $query->where('id', '>=', "1");}, true)        
                ->setRowId( function($param) { return $param->id; })
                ->addIndexColumn()
                ->make(true);        
        }
        return view('admin/SecaosDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Secao = Secao::where($where)->first();
        return Response()->json($Secao);
    }    

    public function destroy(Request $request)
    {        
        $Secao = Secao::where(['id'=>$request->id])->delete();
        return Response()->json($Secao);
    }   

    public function store(SecaoRequest $request)
    {
        $Secao = Secao::updateOrCreate(
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
        return Response()->json($Secao);
    }     

}
