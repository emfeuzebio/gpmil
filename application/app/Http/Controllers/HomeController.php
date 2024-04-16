<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\User;
use App\Models\Pgrad;
use App\Models\Secao;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    protected $Pessoa = null;
    protected $Pgrad = null;
    protected $Secao = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
        $this->Pessoa = new Pessoa();
        $this->Pgrad = new Pgrad();
        $this->Secao = new Secao();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = User::with('pessoa')->find(Auth::user()->id);
        $pessoa = Pessoa::with('pgrad')->find($user->id);
        $qtdPessoasAtivas = $this->Pessoa->all()->count();
        //dd($qtdPessoasAtivas);

        return view('home', ['qtdPessoasAtivas' => $qtdPessoasAtivas, 'user' => $user, 'pessoa' => $pessoa]);
    }
}
