<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome_guerra',
        'user_id',
        'ativo',
    ];

    // public function pessoa() {
    //     return $this->belongsTo(User::class, 'user_id','id');
    // }    

}
