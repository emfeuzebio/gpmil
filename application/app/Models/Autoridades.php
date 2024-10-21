<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoridades extends Model
{
    use HasFactory;

    protected $table = ['pessoas'];

    protected $fillable = [
        'nome_guerra',
        'pgrad_id',
        'funcao_id',
        'ativo'
    ];

    public function pgrad() {
        return $this->hasOne(Pgrad::class, 'id', 'pgrad_id');
    }   

    public function funcao() {
        return $this->hasOne(Funcao::class, 'id', 'funcao_id');
    }
    
}
