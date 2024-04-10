<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QualificacaoRequest extends FormRequest
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
            'codigo' => 'required|unique:qualificacaos|digits:4',
            'sigla' => 'required|min:2',
            'descricao' => 'required|min:3',            
            'ativo' => ['required','in:"SIM","NÃO"'],
        ];
    }
}
