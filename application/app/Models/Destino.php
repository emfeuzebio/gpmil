<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;

    // protected $table = 'destino';                            //tabela de uso
    // public $timestamps = false;                              //desabilita colunas timestamps                    
    protected $fillable = ['organizacao_id','sigla','descricao','ativo'];       //colunas  

    public function apresentacoes() {
        return $this->hasMany(Apresentacao::class);
    }    

}
