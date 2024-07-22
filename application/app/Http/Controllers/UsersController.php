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
        // somente Admin têm permissão
        if (Gate::none(['is_admin'], new User())) {
            abort(403, 'Usuário não autorizado!');
        }

        // return $dataTable->render('users.index');
        return $dataTable->render('admin/UsersDatatable');
    }
}

