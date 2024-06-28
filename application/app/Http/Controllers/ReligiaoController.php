<?php

namespace App\Http\Controllers;

use App\DataTables\ReligiaosDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Religiao;

class ReligiaoController extends Controller
{
    public function index(ReligiaosDataTable $dataTable)
    {
        // se não autenticado faz logout  // Auth::logout();
        if (! Auth::check()) return redirect('/home');

        // somente Admin e EncPes têm permissão
        if (Gate::none(['is_admin','is_encpes'], new Religiao())) {
            abort(403, 'Usuário não autorizado!');
        }      
        
        return $dataTable->render('admin/religiaosDatatable');
    }
}

