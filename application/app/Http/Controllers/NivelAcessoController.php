<?php

namespace App\Http\Controllers;

use App\DataTables\NivelAcessosDataTable;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class NivelAcessoController extends Controller
{
    public function index(NivelAcessosDataTable $dataTable)
    {

        dd(User::with('pessoa')->find(Auth::user()->id));

        
        // dd(session()->all());
        // dd(Auth::user());
        // return $dataTable->render('nivelacessos');
    }
}

