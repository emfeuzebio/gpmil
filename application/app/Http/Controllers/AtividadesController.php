<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AtividadesController extends Controller
{
    public function index()
    {
        if (Gate::none(['is_admin','is_encpes'], new Atividade())) {
            abort(403, 'Usuário não autorizado!');
        } 

        $atividades = Atividade::orderBy('data_hora', 'desc')->get();
        return view('celotex/atividades', compact('atividades'));
    }

    // Retornar as atividades em formato JSON para o Vue.js
    public function getAtividades()
    {
        // Obter todas as atividades
        $atividades = Atividade::all();
    
        // Atualizar o campo "ativo" com base nas datas
        foreach ($atividades as $atividade) {
            $now = Carbon::now();
    
            // Se a data atual estiver entre dt_ini e dt_fim, a atividade está ativa
            if ($now->between($atividade->dh_ini, $atividade->dh_fim)) {
                $atividade->ativo = 'SIM';
            } else {
                $atividade->ativo = 'NÃO';
            }
    
            // Salva a atividade atualizada se necessário
            $atividade->save();
        }
    
        // Retorna as atividades atualizadas
        return response()->json($atividades);
    }

    // Armazenar uma nova atividade
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'local' => 'required|string|max:255',
            'data_hora' => 'required|string',
            'descricao' => 'required|string',
            'dh_ini' => 'required|date',
            'dh_fim' => 'required|date|after_or_equal:dh_ini',
            'ativo' => 'required|in:SIM,NÃO',
        ]);

        // Criação da nova atividade
        Atividade::create([
            'nome' => $request->nome,
            'local' => $request->local,
            'data_hora' => $request->data_hora,
            'descricao' => $request->descricao,
            'dh_ini' => Carbon::parse($request->dh_ini),
            'dh_fim' => Carbon::parse($request->dh_fim),
            'ativo' => $request->ativo,
        ]);

        return response()->json(['message' => 'Atividade adicionada com sucesso!']);
    }

    // Atualizar uma atividade existente
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'local' => 'required|string|max:255',
            'data_hora' => 'required|string',
            'descricao' => 'required|string',
            'dh_ini' => 'required|date',
            'dh_fim' => 'required|date|after_or_equal:dh_ini',
            'ativo' => 'required|in:SIM,NÃO',
        ]);

        // Localiza a atividade a ser atualizada
        $atividade = Atividade::findOrFail($id);

        // Atualiza os dados da atividade
        $atividade->update([
            'nome' => $request->nome,
            'local' => $request->local,
            'data_hora' => $request->data_hora,
            'descricao' => $request->descricao,
            'dh_ini' => Carbon::parse($request->dh_ini),
            'dh_fim' => Carbon::parse($request->dh_fim),
            'ativo' => $request->ativo,
        ]);

        return response()->json(['message' => 'Atividade atualizada com sucesso!']);
    }

    // Excluir uma atividade
    public function destroy($id)
    {
        $atividade = Atividade::findOrFail($id);
        $atividade->delete();

        return response()->json(['message' => 'Atividade excluída com sucesso!']);
    }

    public function getAtividadesAtivas()
    {
        $atividades = Atividade::select('nome', 'local', 'data_hora', 'descricao', 'dh_ini', 'dh_fim', 'ativo')
            ->where('ativo', 'SIM')
            ->whereDate('dh_ini', '<=', now())   // Ativo a partir da dt_ini
            ->whereDate('dh_fim', '>=', now())   // Desativa após a dt_fim
            ->get();

        return response()->json($atividades);
    }

}
