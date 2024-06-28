<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizacaoRequest;
use App\Models\Organizacao;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class OrganizacaoController extends Controller
{
    
    public function __construct() {

    }

    public function index() {

        // se não autenticado faz logout  // Auth::logout();          
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Organizacao())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {

            return DataTables::eloquent(Organizacao::select(['organizacaos.*']))
                ->addIndexColumn()
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
        $Organizacao = Organizacao::where(['id'=>$request->id])->delete();
        return Response()->json($Organizacao);
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
