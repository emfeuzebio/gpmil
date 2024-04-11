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
            'nome_completo' => 'required',            //|unique
            'nome_guerra' => 'required',            //|unique
            'qualificacao_id' => 'required',            //|unique
            'cpf' => 'required',            //|unique
            'idt' => 'required',            //|unique
            'status' => 'required',            //|unique
            'ativo' => ['required','in:"SIM","NÃO"'],
        ];
    }
}