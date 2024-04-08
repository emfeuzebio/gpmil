<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pgrad extends Model
{
    use HasFactory;

    // protected $table = 'pgrads';                            //tabela de uso
    // public $timestamps = false;                             //desabilita colunas timestamps                    
    protected $fillable = ['circulo_id','sigla','descricao','ativo'];       //colunas

    //Quarquer Pgrad pertence a um Circulo
    public function circulo() {
        return $this->belongsTo(Circulo::class);
    }    

}
