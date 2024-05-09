<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizacaoRequest;
use App\Models\Organizacao;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class OrganizacaoController extends Controller
{
    
    public function __construct() {

    }

    public function index() {

        // https://laravel.com/api/10.x/Illuminate/Auth/Access/Gate.html
        // if (Gate::allows(['is_admin','is_encpes'])) {
            // abort(403, 'Usuário não autorizado!');            
            // return redirect('/home');
        // }

        // if (Gate::authorize(['is_admin','is_encpes'])) {
        //     return redirect('/home');
        // }


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
        $Livro = Organizacao::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(OrganizacaoRequest $request)
    {
        //controla permissão, mas neste caso não é necessário pois in index() já bloqueia
        // if (Gate::check(['is_admin','is_encpes'])) {
        //     $mensagem = ['message' => 'Operação NÃO autorizada!','errors' => ['form'=>'Form: Operação NÃO autorizada']];
        //     return Response()->json($mensagem, Response::HTTP_UNPROCESSABLE_ENTITY); //422
        // }

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
