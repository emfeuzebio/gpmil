<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boletim extends Model
{
    use HasFactory;

    protected $table = 'boletins';                                          // tabela de uso
    protected $fillable = ['descricao','data','ativo'];                     // colunas      
    // public $timestamps = false;                                          // desabilita colunas timestamps                    


}
