<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apresentacao extends Model
{
    use HasFactory;

    // protected $dates = ['dt_apres','dt_inicial','dt_final'];
    // protected $dateFormat = 'd/m/Y';
    // protected $dates = ['dt_inicial' => 'd/m/Y'];
    // protected $table = 'apresentacao';

    protected $fillable = [
        'pessoa_id',
        'destino_id',
        'dt_apres',
        'dt_inicial',
        'dt_final',
        'local_destino',
        'celular',
        'observacao',
        'publicado',
        'boletim_id',
        'secao_id',
        'situacao_id',
        'apresentacao_id',
    ];

    public function getDtApresBrAttribute() {
        return date('d/m/Y', strtotime($this->attributes['dt_apres']));
    }    

    public function getDtInicialBrAttribute() {
        return date('d/m/Y', strtotime($this->attributes['dt_inicial']));
    }    

    public function getDtFinalBrAttribute() {
        return date('d/m/Y', strtotime($this->attributes['dt_final']));
    }    

    
    public function pessoa() {
        return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }    
        
    public function boletim() {
        return $this->hasOne(boletim::class, 'id', 'boletim_id');
    }   

    public function destino() {
        return $this->hasOne(Destino::class, 'id', 'destino_id');
    }   

    public function destinoFk() {
        return $this->belongsTo(Destino::class);
    }    
    
    public function secao() {
        return $this->hasOne(Secao::class, 'id', 'secao_id');
    }

    public function situacao() {
        return $this->hasOne(Situacao::class, 'id', 'situacao_id');
    }      

    // public function situacaoFK() {
    //     return $this->belongsTo(Situacao::class);
    // }    


    // https://pt.linkedin.com/pulse/relacionamentos-laravel-um-guia-definitivo-para-dominar-de-paula-lvnwf#:~:text=No%20Laravel%2C%20o%20relacionamento%20%22One%20to%20Many%22%20(um,v%C3%A1rias%20correspond%C3%AAncias%20em%20outra%20tabela.

}
