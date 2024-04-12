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
        'antiguidade', 
        // 'secao_id', 
        'endereco', 
        'cidade', 
        // 'municipio_id', // ??????????
        'uf', 
        'cep', 
        'fone_ramal', 
        'fone_celular', 
        'fone_emergencia', 
        'foto',
        // 'funcao_id',
        // 'nivelacesso_id'
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

    public function nivelacesso() {
        return $this->hasOne(NivelAcesso::class, 'id', 'nivelacesso_id');
    }
    // public function pessoa() {
    //     return $this->belongsTo(User::class, 'user_id','id');
    // }    

}
