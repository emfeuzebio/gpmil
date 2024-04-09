<?php

namespace App\Http\Controllers;

use App\DataTables\NivelAcessosDataTable;

class NivelAcessoController extends Controller
{
    public function index(NivelAcessosDataTable $dataTable)
    {
        return $dataTable->render('admin/nivelacessosDatatable');
    }
}

