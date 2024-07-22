<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Http\Request;
use App\Http\Requests\PgradRequest;   //validação de servidor
use App\Models\Circulo;
use App\Models\Pgrad;

class PgradController extends Controller
{
    protected $Circulo = null;

    public function __construct() {

        $this->Circulo = new Circulo();
    }
    
    public function index() {

        // somente Admin têm permissão
        if (Gate::none(['is_admin'], new Pgrad())) {
            abort(403, 'Usuário não autorizado!');
        }

        if(request()->ajax()) {
            return FacadesDataTables::eloquent(Pgrad::select(['pgrads.*'])->with('circulo'))
                ->setRowId( function($param) { return $param->id; })
                ->addColumn('circulo', function($param) { return $param->circulo->sigla; })
                ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->addIndexColumn()
                ->make(true);        
        }

        //busca lista de Circulos para usar nos combos da view
        $circulos = $this->Circulo->all()->sortBy('id');

        return view('admin/PgradsDatatable',['circulos'=> $circulos]);
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Pgrad = Pgrad::where($where)->first();
        return Response()->json($Pgrad);
    }    

    public function destroy(Request $request)
    {        
        $Pgrad = Pgrad::where(['id'=>$request->id])->delete();
        return Response()->json($Pgrad);
    }   

    public function store(PgradRequest $request)
    {
        $Pgrad = Pgrad::updateOrCreate(
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
        return Response()->json($Pgrad);
    }     

}
