<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Http\Request;
use App\Http\Requests\BoletinsRequest;
use App\Models\Boletins;

class BoletinsController extends Controller
{
    
    public function __construct() {

    }

    public function index() {

        // se não autenticado
        // Auth::logout();          //faz logout
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Boletins())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {
            return FacadesDataTables::eloquent(Boletins::select(['boletins.*']))
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
