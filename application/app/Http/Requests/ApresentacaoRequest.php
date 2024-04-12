<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApresentacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;    //true = não necessita estar logado
    }

    public function rules(): array
    {
        return [
            'pessoa_id' => 'required',
            'destino_id' => 'required',
            'boletim_id' => '',
            // 'dt_apres' => 'required|date',           
            'dt_inicial' => 'required|date',
            'dt_final' => 'required|date',          
            'local_destino' => 'required|min:3',
            'celular' => 'required|min:15',
            'observacao' => '',  
            // 'prtsv' => '',            
            'publicado' => ['required','in:"SIM","NÃO"'],
        ];
    }
}