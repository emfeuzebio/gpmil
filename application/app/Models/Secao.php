<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    use HasFactory;

    // protected $table = 'pgrads';                            //tabela de uso
    // public $timestamps = false;                             //desabilita colunas timestamps                    
    protected $fillable = ['organizacao_id','sigla','descricao','ativo'];       //colunas  

}
