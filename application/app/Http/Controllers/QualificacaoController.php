<?php

namespace App\Http\Controllers;

use App\DataTables\QualificacaosDataTable;
use Illuminate\Http\Request;
use App\Http\Requests\QualificacaoRequest;   //validação de servidor
use App\Models\Qualificacao;
use DataTables;

class QualificacaoController extends Controller
{

    public function __construct() {
        //somente Admin têm permissão
        // $this->authorize('is_admin');
    }

    public function indexRender(QualificacaosDataTable $dataTable)
    {
        // return $dataTable->render('users.Qualificacaos');
    }    
    
    public function index() {

        if(request()->ajax()) {
            // return 
            //     datatables()->of(Qualificacao::select('*'))
            return DataTables::eloquent(Qualificacao::select(['qualificacaos.*']))
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

       //$Qualificacao = Qualificacao::where(['id'=>$request->id]);
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
