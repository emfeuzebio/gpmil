<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;    //true = não necessita estar logado
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pgrad_id' => 'required',
            'nome_completo' => 'required',
            'nome_guerra' => 'required',
            'qualificacao_id' => 'required',
            'cpf' => 'required',            //|unique
            'idt' => 'required',            //|unique
            'status' => ['required','in:"Ativa","Reserva","Civil"'],
            'secao_id' => '',
            'nivelacesso_id' => 'required',
            'funcao_id' => '',
            'ativo' => ['required','in:"SIM","NÃO"'],
            'foto' => ['nullable', 'image', 'max:1024']
        ];
    }
}
