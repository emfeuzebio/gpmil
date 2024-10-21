<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $table = 'ctx_atividades';
    protected $fillable = [
        'nome',
        'local',
        'data_hora',
        'descricao',
        'dh_ini',
        'dh_fim',
        'ativo'
    ];

    protected $dates = ['dh_ini', 'dh_fim'];

    public $timestamps = false;

    public function getAtivoAttribute($value)
    {
        $now = Carbon::now();

        // Se a data atual estiver entre dt_ini e dt_fim, retorna 'SIM'
        if ($now->between($this->dh_ini, $this->dh_fim)) {
            return 'SIM';
        }

        // Caso contrário, retorna 'NÃO'
        return 'NÃO';
    }
}
