<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Apresentacao;
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

        // Realiza a consulta usando Eloquent
        $apresentacoesSemTermino = Apresentacao::semTermino()
            ->where('pessoa_id', $pessoa->id)
            ->get();

        // Verifica se há apresentações sem término
        if ($apresentacoesSemTermino->isNotEmpty()) {
        // Configura a flash message na sessão
        $apresentacaoSemTermino = $apresentacoesSemTermino->first();
        session()->flash('incomplete_apresentacao_alert', [
            'codigo' => 2,
            'registro' => [
                'apresentacao_id' => $apresentacaoSemTermino->id,
                'id' => null,
                'motivo' => $apresentacaoSemTermino->motivo,
            ],
            'mensagem' => "Há uma Apresentação de Início de '{$apresentacaoSemTermino->motivo}' sem Término. Deseja inclui-lá agora? ID {$apresentacaoSemTermino->id}",
        ]);
        return;
        }

    }
}
