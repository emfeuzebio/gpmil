<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\QualificacaoRequest;   //validação de servidor
use App\Models\Qualificacao;
use Yajra\DataTables\Facades\DataTables;

class QualificacaoController extends Controller
{
    public function __construct() {

    }
    
    public function index() {

        // se não autenticado faz logout  // Auth::logout();
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Qualificacao())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {
            return DataTables::eloquent(Qualificacao::select(['qualificacaos.*']))
                ->setRowId( function($param) { return $param->id; })
                ->addIndexColumn()
                ->make(true);        
        }
        return view('admin/QualificacaosDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Qualificacao = Qualificacao::where($where)->first();
        return Response()->json($Qualificacao);
    }    

    public function destroy(Request $request)
    {        
        $Qualificacao = Qualificacao::where(['id'=>$request->id])->delete();
        return Response()->json($Qualificacao);
    }   

    public function store(QualificacaoRequest $request)
    {
       $Qualificacao = Qualificacao::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'codigo' => $request->codigo,
                'sigla' => $request->sigla,
                'descricao' => $request->descricao,
                'ativo' => $request->ativo,
            ]
        );  
        return Response()->json($Qualificacao);
    }     

}
