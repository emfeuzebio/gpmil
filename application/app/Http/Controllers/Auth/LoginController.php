<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        $pessoa = Pessoa::where('user_id', $user->id)->first();

        $hasIncompleteAddressData = $pessoa && $pessoa->hasIncompleteAddressData();
        $hasIncompletePersonalData = $pessoa && $pessoa->hasIncompletePersonalData();

        if ($hasIncompletePersonalData && $hasIncompleteAddressData) {
            session()->flash('incomplete_data_alert', [
                'address' => $hasIncompleteAddressData,
                'personal' => $hasIncompletePersonalData,
            ]);
        }

        $sql = "
            SELECT a.*, destinos.sigla AS motivo
            FROM apresentacaos a 
                LEFT JOIN destinos ON destinos.id = a.destino_id
            WHERE a.pessoa_id = ?
              AND a.apresentacao_id IS NULL
              AND a.boletim_id IS NOT NULL
              AND NOT EXISTS (
                  SELECT * 
                  FROM apresentacaos ae 
                  WHERE ae.pessoa_id = a.pessoa_id
                    AND ae.apresentacao_id = a.id
            )
        ";
        $apresentacaoSemTermino = DB::select($sql, [$pessoa->id]);

        if (!empty($apresentacaoSemTermino)) {
            $apresentacaoSemTermino[0]->apresentacao_id = $apresentacaoSemTermino[0]->id;
            $apresentacaoSemTermino[0]->id = null;

            session()->flash('incomplete_apresentacao_alert', [
                'codigo' => 2,
                'registro' => $apresentacaoSemTermino[0],
                'mensagem' => "Há uma Apresentação de Início de '" . $apresentacaoSemTermino[0]->motivo . "' sem Término. Deseja inclui-ĺá agora? ID " . $apresentacaoSemTermino[0]->apresentacao_id,
            ]);
            return;
        }
    }
}
