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
        'dt_inicial',
        'dt_final',
        'local_destino',
        'celular',
        'observacao',
        'publicado',
        'boletim_id',
        'secao_id',
        // 'dt_apres',
        // 'prtsv',
    ];
    
    public function pessoa() {
        return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }    
    // public function pessoa() {
    //     return $this->belongsTo(Pessoa::class);
    // }    
    
    public function boletim() {
        return $this->hasOne(boletim::class, 'id', 'boletim_id');
    }   
    // public function boletim() {
    //     return $this->belongsTo(Boletim::class);
    // }   

    public function destino() {
        return $this->hasOne(Destino::class, 'id', 'destino_id');
    }   
    // public function destino() {
    //     return $this->belongsTo(Destino::class);
    // }

    public function secao() {
        return $this->hasOne(Secao::class, 'id', 'secao_id');
    }   

}
