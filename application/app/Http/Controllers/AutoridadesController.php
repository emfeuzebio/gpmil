<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autoridades;
use App\Models\Funcao;
use App\Models\Pessoa;
use App\Models\Pgrad;

class AutoridadesController extends Controller
{
    public function index()
    {
        $diretor = Pessoa::where('funcao_id', 1)->with('pgrad')->with('funcao')->first();
        $subdiretor = Pessoa::where('funcao_id', 2)->with('pgrad')->with('funcao')->first();

        // Converte a foto (BLOB) para base64
        if ($diretor && $diretor->foto) {
            $decoded_data = base64_decode($diretor->foto);
            $image = @imagecreatefromstring($decoded_data);

            if ($image !== false) {
                ob_start();
                imagepng($image);
                $data = ob_get_contents();
                ob_end_clean();

                $diretor->foto = 'data:image/png;base64,' . base64_encode($data);
            }
            // $diretor->foto = base64_encode($diretor->foto);
        }

        if ($subdiretor && $subdiretor->foto) {
            $decoded_data = base64_decode($subdiretor->foto);
            $image = @imagecreatefromstring($decoded_data);

            if ($image !== false) {
                ob_start();
                imagepng($image);
                $data = ob_get_contents();
                ob_end_clean();

                $subdiretor->foto = 'data:image/png;base64,' . base64_encode($data);
            }
            // $subdiretor->foto = base64_encode($subdiretor->foto);
        }

        return view('celotex/autoridades', compact('diretor', 'subdiretor'));
    }

    public function getAutoridades()
    {
        // Obtém o Diretor e o Sub-Diretor da tabela 'pessoas'
        $diretor = Pessoa::where('funcao_id', 1)->with('pgrad')->with('funcao')->first();
        $subDiretor = Pessoa::where('funcao_id', 2)->with('pgrad')->with('funcao')->first();
    
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
    

    public function updateAutoridade(Request $request, $tipo)
    {
        $request->validate([
            'id' => 'required|integer|exists:pessoas,id',
        ]);

        $autoridade = Pessoa::find($request->id);
        
        // Atualiza a função conforme o tipo
        if ($tipo === 'diretor') {
            $autoridade->funcao_id = 1; // Atualiza para Diretor
        } elseif ($tipo === 'sub_diretor') {
            $autoridade->funcao_id = 2; // Atualiza para Sub-Diretor
        }

        $autoridade->save();

        return response()->json(['message' => 'Autoridade atualizada com sucesso!']);
    }
}
