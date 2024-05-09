<?php

namespace App\Http\Controllers;

use App\DataTables\MunicipiosDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function index(MunicipiosDataTable $dataTable) {

        // se não autenticado
        // Auth::logout();          //faz logout
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Municipio())) {
            abort(403, 'Usuário não autorizado!');
        }        

        return $dataTable->render('admin/municipiosDatatable');
    }
}

