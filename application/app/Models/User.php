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
        // return $this->belongsTo(Pessoa::class, 'id','user_id');
        return $this->hasOne(Pessoa::class);
    }

    public function preferencia() {
        return $this->belongsTo(Preferencia::class, 'id','user_id');
    }
    
    public function adminlte_image()
    {
        // Certifique-se de que a variável $pessoa esteja corretamente definida
        $pessoa = $this->hasOne(Pessoa::class)->first();
        $image_blob = $pessoa->foto;
    
        // Verifique se o arquivo de imagem existe
        if ($image_blob) {
            // Decodifique os dados base64
            $decoded_data = base64_decode($image_blob);
    
            // Crie uma imagem a partir dos dados decodificados
            $image = imagecreatefromstring($decoded_data);
    
            if ($image !== false) {
                // Salve a imagem em um buffer
                ob_start();
                imagepng($image);
                $data = ob_get_contents();
                ob_end_clean();
    
                return 'data:image/png;base64,' . base64_encode($data);
            } else {
                return 'Erro ao criar a imagem.';
            }
        } else {
            return 'vendor/adminlte/dist/img/avatar.png';
        }
    
    }
    

    public function adminlte_name() {
        $pessoa = $this->hasOne(Pessoa::class)->with('pgrad')->first();
        $nome = $pessoa->pgrad->sigla . ' ' . $pessoa->nome_guerra;
    
        return $nome;
    }

    public function adminlte_desc() {
        $pessoa = $this->hasOne(Pessoa::class)->with('secao', 'nivel_acesso')->first();
        $descricao = $pessoa->nivel_acesso->sigla . ' - ' . $pessoa->secao->sigla;
    
        return $descricao;
    }

    public function adminlte_profile_url() {
        return 'pessoas/username';
    }

}
