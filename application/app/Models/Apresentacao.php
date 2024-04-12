<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apresentacao extends Model
{
    use HasFactory;

    //protected $table = 'pessoas';

    protected $fillable = [
        'pessoa_id',
        'destino_id',
        // 'dt_apres',
        'dt_inicial',
        'dt_final',
        'local_destino',
        'celular',
        'observacao',
        // 'prtsv',
        'publicado',
        'boletim_id',
    ];
    
    public function pessoa() {
        return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }    

    public function destino() {
        return $this->hasOne(Destino::class, 'id', 'destino_id');
    }   

    public function boletim() {
        return $this->hasOne(boletim::class, 'id', 'boletim_id');
    }   

    // public function pessoa() {
    //     return $this->belongsTo(User::class, 'user_id','id');
    // }    

}
