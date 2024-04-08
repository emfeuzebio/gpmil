<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NivelAcesso extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //protected $table = 'nivelacessos';
    
    protected $fillable = [
        'nome',
        'descricao',
        'sigla',
        'ativo',
    ];

}
