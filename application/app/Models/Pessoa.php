<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome_completo',
        'nome_guerra',
        'pgrad_id',
        'qualificacao_id',
        'user_id',
        'ativo',
    ];

    public function pgrad() {
        return $this->hasOne(Pgrad::class, 'id', 'pgrad_id');
    }   
    
    public function qualificacao() {
        return $this->hasOne(Qualificacao::class, 'id', 'qualificacao_id');
    }    

    // public function pessoa() {
    //     return $this->belongsTo(User::class, 'user_id','id');
    // }    

}
