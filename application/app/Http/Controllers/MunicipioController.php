<?php

namespace App\Http\Controllers;

use App\DataTables\MunicipiosDataTable;

class MunicipioController extends Controller
{
    public function index(MunicipiosDataTable $dataTable)
    {
        return $dataTable->render('admin/municipiosDatatable');
    }
}

