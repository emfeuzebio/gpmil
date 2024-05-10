<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Http\Request;
use App\Http\Requests\PessoaRequest;   //validação de servidor
use App\Models\Circulo;
use App\Models\Pgrad;
use App\Models\Pessoa;
use App\Models\Qualificacao;
use App\Models\Secao;
use App\Models\Funcao;
use App\Models\NivelAcesso;
use App\Models\User;


class PessoaController extends Controller
{
    protected $Circulo = null;
    protected $Pgrad = null;
    protected $Qualificacao = null;
    protected $Secao = null;
    protected $Funcao = null;
    protected $NivelAcesso = null;

    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userFuncaoID = 0;
    protected $userNivelAcessoID = 0;

    public function __construct() {

        $this->Circulo = new Circulo();
        $this->Pgrad = new Pgrad();
        $this->Qualificacao = new Qualificacao();
        $this->Secao = new Secao();
        $this->Funcao = new Funcao();
        $this->NivelAcesso = new NivelAcesso();
    }
    
    public function index() {

        // se não autenticado
        // Auth::logout();          //faz logout
        if (! Auth::check()) return redirect('/home');


        $user = User::with('pessoa')->find(Auth::user()->id);
        $this->userID = $user->id;
        $this->userSecaoID = $user->pessoa->secao_id;
        $this->userFuncaoID = $user->pessoa->funcao_id;
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;

        if(request()->ajax()) {

            return FacadesDataTables::eloquent(Pessoa::select(['pessoas.*'])->with('pgrad','qualificacao','secao','funcao','nivel_acesso')->orderBy('pgrad_id')->orderBy('nome_completo'))
                ->addColumn('pgrad', function($param) { return $param->pgrad->sigla; })
                ->addColumn('qualificacao', function($param) { return $param->qualificacao->sigla; })
                ->addColumn('nivel_acesso', function($param) { return $param->nivel_acesso->nome; })
                ->addColumn('secao', function($param) { return $param->secao->sigla; })
                ->addColumn('acoes', function ($param) { return $this->getActionColumn($param); })
                ->rawColumns(['acoes'])
                ->addIndexColumn()
                ->editColumn('created_at', function ($param) { return date("d/m/Y", strtotime($param->created_at)); })
                ->make(true);        
        }


        $pgrads = $this->Pgrad->all()->sortBy('id');
        $qualificacaos = $this->Qualificacao->all()->sortBy('sigla');
        $nivel_acessos = $this->NivelAcesso->all()->sortBy('id');
        $secaos = $this->Secao->all()->sortBy('id');
        $funcaos = $this->Funcao->all()->sortBy('sigla');

        // dd($funcaos);

        return view('admin/PessoasDatatable', ['pgrads'=> $pgrads, 'qualificacaos'=> $qualificacaos, 'nivel_acessos'=> $nivel_acessos, 'secaos'=> $secaos, 'funcaos' => $funcaos]);
    }

    protected function getActionColumn($row): string
    {
        $actions = '';
        $btnEditar  = '<button data-id="' . $row->id . '" class="btnEditar btn btn-primary btn-sm mr-1" data-toggle="tooltip" title="Editar o registro atual">Editar</button>';
        $btnVer  = '<button data-id="' . $row->id . '" class="btnEditar btn btn-info btn-xs btn-sm mr-1" data-toggle="tooltip" title="Ver os detalhes deste registro">Ver</button>';
        $btnExcluir = '<button data-id="' .$row->id . '" class="btnExcluir btn btn-danger btn-sm btn-sm mr-1" data-toggle="tooltip" title="Excluir o registro atual">Excluir</button>';

        // btn Editar disponível apenas para Admin, EncPes, Sgtte ou User dono
        if(in_array($this->userNivelAcessoID,[1,6])) {
            $actions .= $btnEditar;
        }

        if(in_array($this->userNivelAcessoID,[1])) {
            $actions .= $btnExcluir;
        }

        if(in_array($this->userNivelAcessoID,[2,3,4,5])) {
            $actions .= $btnVer;
        }

        return $actions;
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Pessoa = Pessoa::where($where)->first();
        return Response()->json($Pessoa);
    }    

    public function destroy(Request $request)
    {        
        $Livro = Pessoa::where(['id'=>$request->id])->delete();
        return Response()->json($Livro);
    }   

    public function store(PessoaRequest $request)
    {
        $Pessoa = Pessoa::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'pgrad_id' => $request->pgrad_id,
                'nome_completo' => $request->nome_completo,
                'nome_guerra' => $request->nome_guerra,
                'cpf' => $request->cpf,
                'idt' => $request->idt,
                'status' => $request->status,
                'ativo' => $request->ativo,
                'qualificacao_id' => $request->qualificacao_id, 
                'organizacao_id' => 1, 
                'lem' => $request->lem, 
                'email' => $request->email, 
                'segmento' => $request->segmento, 
                'preccp' => $request->preccp,
                'dt_nascimento' => $request->dt_nascimento,
                'dt_praca' => $request->dt_praca,
                'dt_apres_gu' => $request->dt_apres_gu, 
                'dt_apres_om' => $request->dt_apres_om, 
                'dt_ult_promocao' => $request->dt_ult_promocao,
                'pronto_sv' => $request->pronto_sv, 
                // 'user_id',
                'antiguidade' => $request->antiguidade, 
                'secao_id' => $request->secao_id, 
                'endereco' => $request->endereco,
                'cidade' => $request->cidade, 
                'municipio_id' => $request->municipio_id, 
                'uf' => $request->uf, 
                'cep' => $request->cep, 
                'fone_ramal' => $request->fone_ramal, 
                'fone_celular' => $request->fone_celular, 
                'fone_emergencia' => $request->fone_emergencia, 
                'foto' => $request->foto,
                'funcao_id' => $request->funcao_id,
                'nivelacesso_id' => $request->nivelacesso_id
            ]
        );  
        return Response()->json($Pessoa);
    }     

    public function Select() {  

        // Forma de buscar os dados
        // 1 - Direto via Model: já sabe a tabela
        // ->orderBy('pgrad_id')
        $generos = Pessoa::all()->sortBy('nome_completo');

        // $generos = Pgrad::where('id_genero','<','5')->orderBy('descricao')->get();
        // $generos = Pgrad::where('id_genero','<','10')->orderBy('descricao')->get();
        // dd($generos);

        // 2 - Via DB::table: usar a sintaxy própria do DB que abstrai os tipos de Bancos
        // $generos = DB::table('bib_genero')->select('*')->get();

        // 3 - Via DB::select: livre para usar string SQL na mão
        // $sql = 'SELECT * from bib_genero WHERE id_genero < :param';
        // $generos = DB::select($sql, ['param'=> 8]);

        // $sql = 'SELECT * from bib_genero WHERE id_genero < ?';
        // $generos = DB::select($sql, [12]);

        return view('PessoaDatatable',['generos' => $generos]);
 
    }    

}
