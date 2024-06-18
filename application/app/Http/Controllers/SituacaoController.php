<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\SituacaoRequest;
use App\Models\Situacao;
use Yajra\DataTables\Facades\DataTables;

class SituacaoController extends Controller
{
    public function __construct() {

    }

    public function index() {

        // Auth::logout();          // se não autenticado faz logout
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Situacao())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {
            return DataTables::eloquent(Situacao::select(['situacaos.*']))
                ->filter(function ($query) { $query->where('id', '>=', "1");}, true)        
                ->setRowId( function($param) { return $param->id; })
                ->addIndexColumn()
                ->make(true);        
        }
        return view('admin/SituacaosDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Situacao = Situacao::where($where)->first();
        return Response()->json($Situacao);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Situacao::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(SituacaoRequest $request)
    {
        $Situacao = Situacao::updateOrCreate(
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
        return Response()->json($Situacao);
    }     

}
