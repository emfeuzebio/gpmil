<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    // Nome da tabela associada a esta model
    protected $table = 'ctx_slideshow';

    public $timestamps = false;

    // Campos que podem ser preenchidos
    protected $fillable = [
        'caminho_imagem',
        'ativo',
    ];

    // Indica que os campos não devem ser protegidos por atribuição em massa
    protected $guarded = ['id'];
}
