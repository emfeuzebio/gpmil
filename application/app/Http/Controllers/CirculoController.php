<?php

namespace App\Http\Controllers;

use App\DataTables\CirculosDataTable;
use App\Models\Circulo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CirculoController extends Controller
{
    public function index(CirculosDataTable $dataTable)
    {
        // se não autenticado faz logout  // Auth::logout();
        if (! Auth::check()) return redirect('/home');

        // somente Admin têm permissão
        if (Gate::none(['is_admin'], new Circulo())) {
            abort(403, 'Usuário não autorizado!');
        }

        return $dataTable->render('admin/CirculosDatatable');
    }
}

