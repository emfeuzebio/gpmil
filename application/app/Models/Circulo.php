<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Circulo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'descricao',
        'sigla',
        'ativo',
    ];

    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    //um Circulo pode ter muitos Pgrads
    public function pgrad() {
        return $this->hasMany(Pgrad::class);
    } 

}
