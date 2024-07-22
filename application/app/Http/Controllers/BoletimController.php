<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\BoletimRequest;
use App\Models\Boletim;
use Yajra\DataTables\Facades\DataTables;

class BoletimController extends Controller
{
    public function __construct() {
        // WEB controla para que todo controler somente será acessível se usuário logado
    }

    public function index() {

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Boletim())) {
            abort(403, 'Usuário não autorizado!');
        }        

        if(request()->ajax()) {
            return DataTables::eloquent(Boletim::select(['boletins.*']))
                ->setRowId( function($param) { return $param->id; })
                ->addIndexColumn()
                ->editColumn('data', function ($param) { return date("d/m/Y", strtotime($param->data)); })
                ->make(true);        
        }
        return view('admin/BoletimDatatable');
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Boletim = Boletim::where($where)->first();
        return Response()->json($Boletim);
    }    

    public function destroy(Request $request)
    {        
        $Boletim = Boletim::where(['id'=>$request->id])->delete();
        return Response()->json($Boletim);
    }   

    public function store(BoletimRequest $request)
    {
        $Boletim = Boletim::updateOrCreate(
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
        return Response()->json($Boletim);
    }     

}
