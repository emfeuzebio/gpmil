<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanoChamadaRequest extends FormRequest
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
            
            'uf' => 'required',
            'cep' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'endereco' => 'required',
            'fone_celular' => 'required',
            'fone_emergencia' => 'required',
        ];

    }
}
