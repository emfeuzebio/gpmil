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
use App\Models\Religiao;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;


class PessoaController extends Controller
{
    protected $Circulo = null;
    protected $Pgrad = null;
    protected $Qualificacao = null;
    protected $Secao = null;
    protected $Religiao = null;
    protected $Funcao = null;
    protected $NivelAcesso = null;

    protected $userID = 0;
    protected $userSecaoID = 0;
    protected $userReligiaoID = 0;
    protected $userFuncaoID = 0;
    protected $userNivelAcessoID = 0;

    public function __construct() {

        $this->Circulo = new Circulo();
        $this->Pgrad = new Pgrad();
        $this->Qualificacao = new Qualificacao();
        $this->Secao = new Secao();
        $this->Religiao = new Religiao();
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
        $this->userReligiaoID = $user->pessoa->religiao_id;
        $this->userFuncaoID = $user->pessoa->funcao_id;
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;

        // filtros aplicados segundo o níve de acesso
        if(in_array($this->userNivelAcessoID,[1,2,3])) {
            // Admin, Cmt e Enc Pes vem todos registros da OM
            $arrFiltro['coluna'] = 'pessoas.id';
            $arrFiltro['operador'] = '>=';
            $arrFiltro['valor'] = '1';

        } elseif(in_array($this->userNivelAcessoID,[4,5])) {
            // Ch Seç e Sgtte vem todos registros da Seção
            $arrFiltro['coluna'] = 'pessoas.secao_id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userSecaoID;
        } else {
            // Usuário vê apenas seus registro id', '=', $userID
            $arrFiltro['coluna'] = 'pessoas.id';
            $arrFiltro['operador'] = '=';
            $arrFiltro['valor'] = $this->userID;
        }

        if(request()->ajax()) {

            return FacadesDataTables::eloquent(Pessoa::select(['pessoas.*'])
                    ->with('pgrad','qualificacao','secao','funcao','nivel_acesso')
                    ->orderBy('pgrad_id')->orderBy('nome_completo')
                    ->where($arrFiltro['coluna'], $arrFiltro['operador'], $arrFiltro['valor'])
                )
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
        $religiaos = $this->Religiao->all()->sortBy('religiao_seq');

        return view('admin/PessoasDatatable', ['pgrads'=> $pgrads, 'qualificacaos'=> $qualificacaos, 'nivel_acessos'=> $nivel_acessos, 'secaos'=> $secaos, 'funcaos' => $funcaos, 'religiaos' => $religiaos]);
    }

    protected function getActionColumn($row): string
    {
        $actions = '';
        $btnEditar  = '<button data-id="' . $row->id . '" class="btnEditar  btn btn-primary btn-xs mr-1" data-toggle="tooltip" title="Editar o registro atual">Editar</button>';
        $btnVer     = '<button data-id="' . $row->id . '" class="btnEditar  btn btn-info    btn-xs btn-sm mr-1" data-toggle="tooltip" title="Ver os detalhes deste registro">Ver</button>';
        $btnExcluir = '<button data-id="' . $row->id . '" class="btnExcluir btn btn-danger  btn-xs btn-sm mr-1" data-toggle="tooltip" title="Excluir o registro atual">Excluir</button>';

        // btn Editar disponível para Admin, EncPes, Sgtte ou User dono
        if(in_array($this->userNivelAcessoID,[1,3,5,6])) {
            $actions .= $btnEditar;
        }

        // btn Excluir apenas disponível para Admin
        if(in_array($this->userNivelAcessoID,[1])) {
            $actions .= $btnExcluir;
        }

        // btn Ver disponível para Cmt e Ch Sec
        if(in_array($this->userNivelAcessoID,[2,4])) {

            // btn Editar disponível se o User for o dono da linha
            if($row->user_id == $this->userID) {
                $actions .= $btnEditar;
            } else {
                $actions .= $btnVer;
            }
        }

        return $actions;
    }

    public function edit(Request $request)
    {        
        $where = array('id'=>$request->id);
        $Pessoa = Pessoa::where($where)->first();
        $pessoaArray = $Pessoa->toArray();

        $binaryFields = ['longblob_field'];
        
        foreach ($binaryFields as $field) {
            if (isset($pessoaArray[$field])) {
                $pessoaArray[$field] = base64_encode($pessoaArray[$field]);
            }
        }
        $pessoaObject = (object) $pessoaArray;
        // print_r($Pessoa);
        // dd($pessoaData);
        // $loggedUserPessoa = Pessoa::where('user_id', Auth::id())->first();
        // $Pessoa->user_nivelacesso_id = $loggedUserPessoa->nivelacesso_id;
        return Response()->json($pessoaObject);
    }    

    public function destroy(Request $request)
    {   
        $user = User::with('pessoa')->find(Auth::user()->id);
        $this->userNivelAcessoID = $user->pessoa->nivelacesso_id;
        // Somente User com nível de acesso Admin pode excluir uma Pessoa
        if ($this->userNivelAcessoID == 1) {
            // Excluir Pessoa
            $PessoaExcluida = Pessoa::where(['id' => $request->id])->delete();
            
            // Verificar se a Pessoa foi excluída antes de excluir o User
            if ($PessoaExcluida) {
                // Excluir User com o mesmo id
                $UserExcluido = User::where(['id' => $request->id])->delete();
            }
        }
    
        return response()->json(['PessoaExcluida' => $PessoaExcluida, 'UserExcluido' => isset($UserExcluido) ? $UserExcluido : false]);
    }
    
    public function store(PessoaRequest $request)
    {   
        $user = User::with('pessoa')->find(Auth::user()->id);

        $editandoNivelRestrito = $user->pessoa->nivelacesso_id == 3 && $request->nivelacesso_id == 1;
        if ($request->id) {
            $atualPessoa = Pessoa::find($request->id);
        }
    
        if(in_array($user->pessoa->nivelacesso_id,[1,3])) {
            $dadosRestritos = 
            [ 
                'funcao_id' => $request->funcao_id,
                'secao_id' => $request->secao_id,
                'status' => $request->status,
                'ativo' => $request->ativo,
                'nivelacesso_id' => $editandoNivelRestrito ? $atualPessoa->nivelacesso_id : $request->nivelacesso_id
            ];
        } elseif (in_array($user->pessoa->nivelacesso_id,[5]) || $request->id == $user->id) {
            $dadosRestritos = ['funcao_id' => $request->funcao_id];
        } else {
            $dadosRestritos = [];
        }
    
        $dadosComuns =
        [
            'pgrad_id' => $request->pgrad_id,
            'nome_completo' => $request->nome_completo,
            'nome_guerra' => $request->nome_guerra,
            'cpf' => $request->cpf,
            'idt' => $request->idt,
            'qualificacao_id' => $request->qualificacao_id,
            'religiao_id' => $request->religiao_id,
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
            'antiguidade' => $request->antiguidade, 
            'endereco' => $request->endereco,
            'cidade' => $request->cidade, 
            'municipio_id' => $request->municipio_id, 
            'uf' => $request->uf, 
            'cep' => $request->cep, 
            'fone_ramal' => $request->fone_ramal, 
            'fone_celular' => $request->fone_celular, 
            'fone_emergencia' => $request->fone_emergencia,
        ];
    
        // Tratamento da foto
        if ($request->hasFile('foto')) {
            // Lê o conteúdo do arquivo
            $foto = file_get_contents($request->foto->getRealPath());
            $dadosComuns['foto'] = base64_encode($foto); // Armazena a imagem como base64 no banco de dados
        } else {
            // Caso a foto não seja enviada, define como null ou mantém a existente
            $dadosComuns['foto'] = null;
        }
    
        // Cria ou atualiza a pessoa
        $Pessoa = Pessoa::updateOrCreate(
            [
                'id' => $request->id,
            ],
            array_merge($dadosComuns, $dadosRestritos)
        );

        return Response()->json($Pessoa);
    }
    
    /**
     * Mantido para consulta e estudo
     */
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
