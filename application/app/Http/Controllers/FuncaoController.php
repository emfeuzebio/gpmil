<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\FuncaoRequest;
use Illuminate\Http\Request;
use App\Models\Funcao;
use Yajra\DataTables\Facades\DataTables;

class FuncaoController extends Controller
{
    
    public function __construct() {

    }

    public function index() {

        // se não autenticado
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Funcao())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {

            return DataTables::eloquent(Funcao::select(['funcaos.*']))
                ->filter(function ($query) { $query->where('id', '>=', "1");}, true)        
                ->setRowId( function($param) { return $param->id; })
                ->addIndexColumn()
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
        $Funcao = Funcao::where(['id'=>$request->id])->delete();
        return Response()->json($Funcao);
    }   

    public function store(FuncaoRequest $request)
    {
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
