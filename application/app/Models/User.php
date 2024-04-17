<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function pessoa() {
        return $this->belongsTo(Pessoa::class, 'id','user_id');
    }

    public function adminlte_image() {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc() {
        $pessoa = $this->hasOne(Pessoa::class)->with('pgrad', 'secao')->first();
        $descricao = $pessoa->pgrad->sigla . ' ' . $pessoa->nome_guerra . ' - ' . $pessoa->secao->sigla;
    
        return $descricao;
    }

    public function adminlte_profile_url() {
        return 'pessoa/username';
    }

}
