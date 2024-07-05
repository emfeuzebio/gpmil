<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = [
        'pgrad_id', 
        'qualificacao_id', 
        // 'organizacao_id', // ??????????
        'lem', 
        'nome_completo', 
        'nome_guerra', 
        'cpf', 
        'idt', 
        'email', 
        'segmento', 
        'preccp', 
        'dt_nascimento', 
        'dt_praca', 
        'dt_apres_gu', 
        'dt_apres_om', 
        'dt_ult_promocao', 
        'status', 
        'pronto_sv', 
        // 'user_id', 
        'ativo', 
        // 'antiguidade', 
        'secao_id',
        'religiao_id',
        'municipio_id', // ??????????
        'uf', 
        'cep', 
        'endereco',
        'cidade', 
        'fone_ramal', 
        'fone_celular', 
        'fone_emergencia', 
        'foto',
        'funcao_id',
        'nivelacesso_id'
    ];

    public function pgrad() {
        return $this->hasOne(Pgrad::class, 'id', 'pgrad_id');
    }   
    
    public function qualificacao() {
        return $this->hasOne(Qualificacao::class, 'id', 'qualificacao_id');
    }    

    public function secao() {
        return $this->hasOne(Secao::class, 'id', 'secao_id');
    }

    public function funcao() {
        return $this->hasOne(Funcao::class, 'id', 'funcao_id');
    }

    public function religiao() {
        return $this->hasOne(Religiao::class, 'id', 'religiao_id');
    }

    public function nivel_acesso() {
        return $this->hasOne(NivelAcesso::class, 'id', 'nivelacesso_id');
    }
    
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setIdtAttribute($value)
    {
        $this->attributes['idt'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setNomeGuerraAttribute($value)
    {
        $this->attributes['nome_guerra'] = mb_strtoupper($value);
    }

    public function setNomeCompletoAttribute($value)
    {
        $this->attributes['nome_completo'] = mb_strtoupper($value);
    }

    /**
     * Check if the pessoa has incomplete address data.
     *
     * @return bool
     */
    public function hasIncompleteAddressData()
    {
        $addressFields = [
            'municipio_id',
            'uf', 
            'cep', 
            'endereco',
            'bairro',
            'cidade', 
            'complemento', 
            // 'fone_ramal', 
            'fone_celular', 
            'fone_emergencia',
            'pessoa_emergencia'
        ];

        foreach ($addressFields as $field) {
            if (empty($this->{$field})) {
                return true; // Retorna true se algum campo de endereço estiver vazio ou null
            }
        }

        return false; // Retorna false se todos os campos de endereço estiverem preenchidos
    }

    /**
     * Check if the pessoa has incomplete personal data.
     *
     * @return bool
     */
    public function hasIncompletePersonalData()
    {
        $personalFields = [
            'pgrad_id', 
            'qualificacao_id', 
            'lem', 
            'nome_completo', 
            'nome_guerra', 
            'cpf', 
            'idt', 
            'email', 
            'segmento', 
            'preccp', 
            'dt_nascimento', 
            // 'dt_praca', 
            'dt_apres_gu', 
            'dt_apres_om', 
            'dt_ult_promocao', 
            'status', 
            'pronto_sv', 
            'ativo', 
            'secao_id',
            'religiao_id',
            'funcao_id',
            'nivelacesso_id',
            'foto'
        ];

        foreach ($personalFields as $field) {
            if (empty($this->{$field})) {
                return true; // Retorna true se algum campo pessoal estiver vazio ou null
            }
        }

        return false; // Retorna false se todos os campos pessoais estiverem preenchidos
    }

}
