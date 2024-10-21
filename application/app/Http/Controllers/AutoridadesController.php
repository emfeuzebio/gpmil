<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autoridades;
use App\Models\Funcao;
use App\Models\Pessoa;
use App\Models\Pgrad;
use Illuminate\Support\Facades\Gate;

class AutoridadesController extends Controller
{
    public function index()
    {
        if (Gate::none(['is_admin','is_encpes'], new Pessoa())) {
            abort(403, 'Usuário não autorizado!');
        }      

        return view('celotex/autoridades');
        // return view('celotex/autoridades');
    }

    public function getAutoridades()
    {
        // Obtém o Diretor e o Sub-Diretor da tabela 'pessoas'
        $diretor = Pessoa::where('funcao_id', 1)
            ->with(['pgrad:id,sigla', 'funcao:id,descricao'])
            ->select('nome_guerra', 'pgrad_id', 'funcao_id', 'foto')
            ->first();

        $subDiretor = Pessoa::where('funcao_id', 20)
            ->with(['pgrad:id,sigla', 'funcao:id,descricao'])
            ->select('nome_guerra', 'pgrad_id', 'funcao_id', 'foto')
            ->first();
        if (!$subDiretor) {
            $subDiretor = Pessoa::where('funcao_id', 2)
            ->with(['pgrad:id,sigla', 'funcao:id,descricao'])
            ->select('nome_guerra', 'pgrad_id', 'funcao_id', 'foto')
            ->first();
        }
    
        // Array para armazenar as autoridades
        $autoridades = [];
    
        // Verifica se o Diretor existe e obtém quem está respondendo por ele (funcao_id = 19)
        if ($diretor) {
            $respondendoDiretor = Pessoa::where('funcao_id', 19)->with('pgrad')->with('funcao')->first();
            $diretor->respondendo = $respondendoDiretor ? $respondendoDiretor->nome_guerra : null;
    
            // Converte a foto (BLOB) para base64
            if ($diretor->foto) {
                $decoded_data = base64_decode($diretor->foto);
                $image = @imagecreatefromstring($decoded_data);
    
                if ($image !== false) {
                    ob_start();
                    imagepng($image);
                    $data = ob_get_contents();
                    ob_end_clean();
    
                    $diretor->foto = 'data:image/png;base64,' . base64_encode($data);
                }
            }
    
            $autoridades[] = $diretor;
        }
    
        // Verifica se o Sub-Diretor existe e obtém quem está respondendo por ele (funcao_id = 20)
        if ($subDiretor) {
            $respondendoSubDiretor = Pessoa::where('funcao_id', 20)->with('pgrad')->with('funcao')->first();
            $subDiretor->respondendo = $respondendoSubDiretor ? $respondendoSubDiretor->nome_guerra : null;
    
            // Converte a foto (BLOB) para base64
            if ($subDiretor->foto) {
                $decoded_data = base64_decode($subDiretor->foto);
                $image = @imagecreatefromstring($decoded_data);
    
                if ($image !== false) {
                    ob_start();
                    imagepng($image);
                    $data = ob_get_contents();
                    ob_end_clean();
    
                    $subDiretor->foto = 'data:image/png;base64,' . base64_encode($data);
                }
            }
    
            $autoridades[] = $subDiretor;
        }
    
        return response()->json($autoridades);
    }
    
    public function getPessoas()
    {
        $pessoas = Pessoa::where('ativo', 'SIM')
            ->with(['pgrad:id,sigla', 'funcao:id,descricao'])
            ->select('nome_guerra', 'pgrad_id', 'funcao_id', 'foto')
            ->first();

        return response()->json($pessoas);
    }

    public function update(Request $request, $id)
    {
        
    }
}
