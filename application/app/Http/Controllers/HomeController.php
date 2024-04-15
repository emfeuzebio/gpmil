<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\User;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    protected $Pessoa = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
        $this->Pessoa = new Pessoa();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $qtdPessoasAtivas = $this->Pessoa->all()->count();
        //dd($qtdPessoasAtivas);

        return view('home', ['qtdPessoasAtivas' => $qtdPessoasAtivas]);
    }
}
