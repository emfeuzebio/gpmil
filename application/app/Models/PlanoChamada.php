<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoChamada extends Model
{
    use HasFactory;
    
    protected $table = 'pessoas';

    protected $fillable = ['endereco','bairro','cidade','municipio_id','uf','cep','fone_celular','fone_emergencia'];

    public function pgrad() {
        return $this->hasOne(Pgrad::class, 'id', 'pgrad_id');
    }   

    public function secao() {
        return $this->hasOne(Secao::class, 'id', 'secao_id');
    }


}
