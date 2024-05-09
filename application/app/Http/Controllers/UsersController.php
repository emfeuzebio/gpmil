<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        // se não autenticado
        // Auth::logout();          //faz logout
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new User())) {
            abort(403, 'Usuário não autorizado!');
        }

        // return $dataTable->render('users.index');
        return $dataTable->render('admin/UsersDatatable');
    }
}

