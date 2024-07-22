<?php

namespace App\Http\Controllers;

use App\DataTables\NivelAcessosDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\NivelAcesso;

class NivelAcessoController extends Controller
{
    public function index(NivelAcessosDataTable $dataTable)
    {
        // somente Admin têm permissão
        if (Gate::none(['is_admin'], new NivelAcesso())) {
            abort(403, 'Usuário não autorizado!');
        }

        return $dataTable->render('admin/nivelacessosDatatable');
    }
}

