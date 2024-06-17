<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\DestinoRequest;
use App\Models\Destino;
use Yajra\DataTables\Facades\DataTables;

class DestinoController extends Controller
{
    
    public function __construct() {

    }

    public function index() {

        // Auth::logout();          // se não autenticado faz logout
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Destino())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {
            return DataTables::eloquent(Destino::select(['destinos.*']))
                ->setRowId( function($param) { return $param->id; })
                ->addIndexColumn()
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
